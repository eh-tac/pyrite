import { Prop, PropObject, PropAny, PropBool, PropChar, PropStr } from "./prop";

export class PHPPropWriter {
  public constructor(public prop: Prop) {}

  public get labelExpr(): string {
    return this.prop.enumName ? `get${this.prop.name}Label()` : this.prop.name;
  }

  public get offsetExpr(): string {
    return this.prop.previousValueOffset ? "$offset" : this.prop.offset;
  }

  public getExpression(object: string = "$this"): string {
    return `${object}.${this.prop.name}`;
  }

  // functions in class order:
  // imports
  // declaration,
  // loading in the constructor,
  // utility functions (like enum labels)
  // output for saving

  public get hexImports(): string[] {
    return [this.prop.hexGetter, this.prop.hexSetter].filter(s => !!s);
  }

  public get classImports(): string[] {
    if (this.prop instanceof PropObject) {
      return [this.prop.structName];
    }
    return [];
  }

  public get propertyDeclaration(): string {
    let type = this.typeExpr;
    if (this.prop.isArray) {
      type = `${type}[]`;
    }

    let p = `$${this.prop.name}`;
    if (this.prop.isStatic) {
      p = `const ${this.prop.name} = ${this.prop.reservedValue}`;
    }
    p = `public ${p};`;
    if (this.prop.comment) {
      p = `${p} //${this.prop.comment}`;
    }
    return `/** @var ${type} ${this.prop.docString} */\n    ${p}`;
  }

  public get typeExpr(): string {
    if (this.prop instanceof PropObject) {
      return this.prop.structName;
    } else if (this.prop instanceof PropBool) {
      return "boolean";
    } else if (this.prop instanceof PropChar || this.prop instanceof PropStr) {
      return "string";
    } else if (this.prop instanceof PropAny) {
      return "mixed";
    }
    return "integer";
  }

  public getConstructorInit(): string {
    let offsetExpr = "";
    if (this.prop.isStatic) {
      if (this.prop.previousValueOffset) {
        // ensure the offset is correct if the final prop is statically ignored
        offsetExpr = `\n        $offset += ${this.propLength};`;
      }
      return `// static ${this.prop.type} value ${this.prop.name} = ${this.prop.reservedValue}${offsetExpr}`;
    }

    const p = `$this->${this.prop.name}`;
    let init = `${p} = ${this.getGetter()};`;
    if (this.prop.isArray) {
      init = `${p} = [];
        $offset = ${this.offsetExpr};
        for ($i = 0; $i < ${this.arrayLength}; $i++) {
            $t = ${this.getGetter(true)};
            ${p}[] = $t;
            $offset += ${this.propLength};
        }`;
    } else if (!this.prop.isFixedLength) {
      // strings and objects have dynamic lengths so the offsets must be adjusted on the flyF
      // if this is a string with a defined offset, make sure that is included when incrementing the offset
      // otherwise if already in previous value mode, just += by the current length;
      const op = this.prop.previousValueOffset ? "+=" : `= ${this.prop.offset} +`;
      offsetExpr = `\n        $offset ${op} ${this.propLength};`;
    }
    return `${init}${offsetExpr}`;
  }

  public getGetter(inLoop = false): string {
    const off = inLoop ? "$offset" : this.offsetExpr;
    if (this.prop instanceof PropObject) {
      return `(new ${this.prop.structName}(substr($hex, ${off}), $this->TIE))->loadHex()`;
    } else if (this.prop instanceof PropAny) {
      return `undefined`;
    }
    const params = ["$hex", off];
    if (this.prop instanceof PropChar) {
      params.push(this.typeLength);
    }

    return `$this->${this.prop.hexGetter}(${params.join(", ")})`;
  }

  public get arrayLength(): string {
    if (this.prop.arrayLengthExpression) {
      return `$this->${this.prop.arrayLengthExpression.replace("-", "->")}`;
    }
    return this.prop.arrayLengthValue.toString(10);
  }

  public get typeLength(): string {
    if (this.prop.typeLengthExpression) {
      const obj = this.prop.isArray ? "t" : `this`;
      return `$${obj}->${this.prop.typeLengthExpression}`;
    }
    return this.prop.baseSize.toString(10);
  }

  public get propLength(): string {
    const obj = this.prop.isArray ? "$t" : `$this->${this.prop.name}`;
    if (this.prop instanceof PropStr) {
      return `strlen(${obj})`;
    } else if (this.prop instanceof PropObject) {
      return `${obj}->getLength()`;
    }
    return this.typeLength;
  }

  public get enumLookupFunction(): string {
    const name = this.prop.name;
    const enumName = this.prop.enumName.toUpperCase();

    return `
    public function get${name}Label() 
    {
        return isset($this->${name}) && isset(Constants::$${enumName}[$this->${name}]) ? Constants::$${enumName}[$this->${name}] : "Unknown";
    }`;
  }

  public getOutputHex(): string {
    const offsetExpr = "";
    const p = `$this->${this.prop.name}`;
    let out = `${this.getSetter(this.prop.isStatic ? this.prop.reservedValue.toString() : p)};`;
    if (this.prop.isArray) {
      out = `$offset = ${this.offsetExpr};
        for ($i = 0; $i < ${this.arrayLength}; $i++) {
            $t = ${p}[$i];
            ${this.getSetter("$t", true)};
            $offset += ${this.propLength};
        }`;
    }
    return `${offsetExpr}${out}`;
  }

  public getSetter(propOverride?: string, inLoop = false): string {
    const off = inLoop ? "$offset" : this.offsetExpr;
    const params = [propOverride || `$this->${this.prop.name}`, "$hex", off];
    return `$hex = $this->${this.prop.hexSetter}(${params.join(", ")})`;
  }
}

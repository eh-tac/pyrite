import { Prop, PropObject, PropAny, PropBool, PropChar, PropStr } from '../prop';

export class PHPPropWriter {
  public constructor(public prop: Prop) {}

  public get labelExpr(): string {
    return this.prop.enumName ? `get${this.prop.name}Label()` : this.prop.name;
  }

  public get offsetExpr(): string {
    return this.prop.previousValueOffset ? '$offset' : this.prop.offset;
  }

  public getExpression(object: string = '$this'): string {
    return `${object}.${this.prop.name}`;
  }

  // functions in class order:
  // imports
  // declaration,
  // loading in the constructor,
  // utility functions (like enum labels)
  // output for saving

  public get hexImports(): string[] {
    return [this.prop.hexGetter, this.prop.hexSetter].filter((s) => !!s);
  }

  public get classImports(): string[] {
    if (this.prop instanceof PropObject) {
      return [this.prop.structName];
    }
    return [];
  }

  /**
   * For generating the property declarations at the top of the base classes
   * @example
   * ```php
   *   /** 0x000 Name STR * /
   *   public string $Name;
   *
   *  /**  FLIGHTGROUPLENGTH INT * /
   *  public const FLIGHTGROUPLENGTH = 1378; // possibly a comment too
   * ```
   */
  public get propertyDeclaration(): string {
    const { isArray, isStatic, name, reservedValue, comment, docString } = this.prop;

    const propertyType = isArray ? 'array' : this.typeExpr;
    const docType = isArray ? `array<${this.typeExpr}>` : this.typeExpr;

    // static properties are declared with const and assigned their value
    const declaration = isStatic ? `const ${name} = ${reservedValue}` : `${propertyType} $${name}`;

    return [
      `/** @var ${docType} ${docString.trim()} */`,
      `public ${declaration};${comment ? ` // ${comment}` : ''}`
    ].join('\n\t');
  }

  /**
   * The type expression for use in property declarations
   */
  public get typeExpr(): string {
    if (this.prop instanceof PropObject) {
      return this.prop.structName;
    } else if (this.prop instanceof PropBool) {
      return 'bool';
    } else if (this.prop instanceof PropChar || this.prop instanceof PropStr) {
      return 'string';
    } else if (this.prop instanceof PropAny) {
      return 'mixed';
    }
    return 'int';
  }

  public getLoadHexInitializer(): string {
    let offsetExpr = '';
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
      // if this is a dynamic array with a length of 0 because it needs to be handled in the non-base class, add a phpstan-ignore comment to avoid the error about the array being always false
      const ignore = this.arrayLength === '0' ? `\n\t\t// @phpstan-ignore smaller.alwaysFalse` : '';
      init = `${p} = [];
        $offset = ${this.offsetExpr};${ignore}
        for ($i = 0; $i < ${this.arrayLength}; $i++) {
            $t = ${this.getGetter(true)};
            ${p}[] = $t;
            $offset += ${this.propLength};
        }`;
    } else if (!this.prop.isFixedLength) {
      // strings and objects have dynamic lengths so the offsets must be adjusted on the fly
      // if this is a string with a defined offset, make sure that is included when incrementing the offset
      // otherwise if already in previous value mode, just += by the current length;
      const op = this.prop.previousValueOffset ? '+=' : `= ${this.prop.offset} +`;
      offsetExpr = `\n        $offset ${op} ${this.propLength};`;
    }
    return `${init}${offsetExpr}`;
  }

  public getGetter(inLoop = false): string {
    const off = inLoop ? '$offset' : this.offsetExpr;
    if (this.prop instanceof PropObject) {
      return `(new ${this.prop.structName}(substr($hex, ${off}), $this->TIE))->loadHex()`;
    } else if (this.prop instanceof PropAny) {
      return `undefined`;
    }
    const params = ['$hex', off];
    if (this.prop instanceof PropChar) {
      params.push(this.typeLength);
    }

    return `$this->${this.prop.hexGetter}(${params.join(', ')})`;
  }

  public get arrayLength(): string {
    if (this.prop.arrayLengthExpression) {
      return `$this->${this.prop.arrayLengthExpression.replace('-', '->')}`;
    }
    return this.prop.arrayLengthValue.toString(10);
  }

  public get typeLength(): string {
    if (this.prop.typeLengthExpression) {
      const obj = this.prop.isArray ? 't' : `this`;
      return `$${obj}->${this.prop.typeLengthExpression}`;
    }
    return this.prop.baseSize.toString(10);
  }

  public get propLength(): string {
    const obj = this.prop.isArray ? '$t' : `$this->${this.prop.name}`;
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
    public function get${name}Label(): string 
    {
        return isset($this->${name}) && isset(Constants::$${enumName}[$this->${name}]) ? Constants::$${enumName}[$this->${name}] : "Unknown";
    }`;
  }

  public getOutputHex(): string {
    const offsetExpr = '';
    const p = `$this->${this.prop.name}`;
    let out = `${this.getSetter(this.prop.isStatic ? this.prop.reservedValue.toString() : p)};`;
    if (this.prop.isArray) {
      // if this is a dynamic array with a length of 0 because it needs to be handled in the non-base class, add a phpstan-ignore comment to avoid the error about the array being always false
      const ignore = this.arrayLength === '0' ? `\n\t\t// @phpstan-ignore smaller.alwaysFalse` : '';
      out = `$offset = ${this.offsetExpr};${ignore}
        for ($i = 0; $i < ${this.arrayLength}; $i++) {
            $t = ${p}[$i];
            ${this.getSetter('$t', true)};
            $offset += ${this.propLength};
        }`;
    }
    return `${offsetExpr}${out}`;
  }

  public getSetter(propOverride?: string, inLoop = false): string {
    const off = inLoop ? '$offset' : this.offsetExpr;
    const params = [propOverride || `$this->${this.prop.name}`, '$hex', off];
    return `$hex = $this->${this.prop.hexSetter}(${params.join(', ')})`;
  }
}

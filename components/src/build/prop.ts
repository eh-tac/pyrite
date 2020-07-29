import { Constants } from "./constants";
import { Struct } from "./struct";
import * as lodash from "lodash";

export type PropType = "SHORT" | "BYTE" | "BOOL" | "SBYTE" | "INT" | "STR" | "CHAR" | "any" | string;

export class Prop {
  public baseSize = 1;
  public typeLengthExpression = "";
  public arrayLengthValue: number;
  public arrayLengthExpression = "";
  public reservedValue?: number;
  public enumName: string = "";
  public comment: string = "";

  public hexGetter: string;
  public hexSetter: string;

  constructor(public offset: string, public name: string, public type: PropType) {}

  public handleTypeLength(lengthStr: string): this {
    if (lengthStr) {
      const lengthInt = parseInt(lengthStr);
      if (isNaN(lengthInt)) {
        this.typeLengthExpression = lengthStr;
      } else {
        this.baseSize = lengthInt;
      }
    }
    return this;
  }

  public handleArrayLength(lengthStr: string): this {
    if (lengthStr) {
      const lengthInt = parseInt(lengthStr);
      if (isNaN(lengthInt)) {
        this.arrayLengthExpression = lengthStr;
      } else {
        this.arrayLengthValue = lengthInt;
      }
    }
    return this;
  }

  public handleRest(restStr: string): this {
    if (restStr) {
      const resv = restStr.match(/Reserved\((\-?\w*)\)/);
      if (resv) {
        this.reservedValue = parseInt(resv[1], 16);
        restStr = restStr.replace(resv[0], "").trim();
      }

      const enumMatch = restStr.match(/\(enum\s?(\w*)?\)/);
      if (enumMatch) {
        this.enumName = enumMatch[1] || this.name;
        restStr = restStr.replace(enumMatch[0], "").trim();
      }

      this.comment = restStr;
    }
    return this;
  }

  public get size(): number {
    const mult = this.isArray ? this.arrayLengthValue : 1;
    return this.baseSize * mult;
  }

  public get isArray(): boolean {
    return this.arrayLengthValue !== undefined || !!this.arrayLengthExpression;
  }

  public get previousValueOffset(): boolean {
    return this.offset === "PV";
  }

  public get isEnum(): boolean {
    return !!this.enumName;
  }

  public get isStatic(): boolean {
    return this.reservedValue !== undefined;
  }

  public get isFixedLength(): boolean {
    return this.baseSize !== 0;
  }

  public getFunctionStubs(): string[] {
    return [this.typeLengthExpression, this.arrayLengthExpression].filter((expr: string): boolean => {
      return expr && expr.substr(-2, 2) === "()";
    });
  }

  // ^^ processing ^^

  public prepare(structs: { [key: string]: Struct }): void {
    // do nothing except if object
  }

  // vv output vv

  public getExpression(object: string = "this"): string {
    return `${object}.${this.name}`;
  }

  public getConstructorInit(): string {
    let offsetExpr = "";
    if (this.isStatic) {
      if (this.previousValueOffset) {
        // ensure the offset is correct if the final prop is statically ignored
        offsetExpr = `\n    offset += ${this.typeLength};`;
      }
      return `// static prop ${this.name}${offsetExpr}`;
    }

    const p = `this.${this.name}`;
    let init = `${p} = ${this.tsGetter};`;
    if (this.isArray) {
      init = `${p} = [];
    offset = ${this.tsOffset};
    for (let i = 0; i < ${this.arrayLength}; i++) {
      const t = ${this.tsGetter};
      ${p}.push(t);
      offset += ${this.typeLength};
    }`;
    } else if (!this.isFixedLength) {
      // strings and objects have dynamic lengths so the offsets must be adjusted on the fly
      // if this is a string with a defined offset, make sure that is included when incrementing the offset
      // otherwise if already in previous value mode, just += by the current length;
      const op = this.previousValueOffset ? "+=" : `= ${this.offset} +`;
      offsetExpr = `\n    offset ${op} ${this.typeLength}`;
    }
    return `${init}${offsetExpr}`;
  }

  public getOutputHex(): string {
    const offsetExpr = "";
    const p = `this.${this.name}`;
    let out = `${this.getSetter(this.isStatic ? this.reservedValue.toString() : p)};`;
    if (this.isArray) {
      out = `offset = ${this.tsOffset};
    for (let i = 0; i < ${this.arrayLength}; i++) {
      const t = ${p}[i];
      ${this.getSetter("t")};
      offset += ${this.typeLength};
    }`;
    }
    return `${offsetExpr}${out}`;
  }

  public getFieldProps(constantLookup: object, _plt: string): object {
    const props = {
      name: this.name,
      type: this.type
    };
    if (this.enumName && constantLookup[this.enumName]) {
      const constants = constantLookup[this.enumName] as Constants;
      props["options"] = `Constants.${this.enumName.toUpperCase()}`;
    }
    return props;
  }

  public get propertyDeclaration(): string {
    let type = this.tsType;
    if (this.isArray) {
      type = `${type}[]`;
    }

    let p = `${this.name}: ${type}`;
    if (this.isStatic) {
      p = `readonly ${p} = ${this.reservedValue}`;
    }
    p = `public ${p};`;
    if (this.comment) {
      p = `${p} //${this.comment}`;
    }
    return p;
  }

  public get enumLookupFunction(): string {
    const name = this.name;
    const enumName = this.enumName.toUpperCase();

    return `
  public get ${name}Label(): string {
    return Constants.${enumName}[this.${name}] || "Unknown";
  }`;
  }

  public get tsType(): string {
    return "number";
  }

  public get hexImports(): string[] {
    return [];
  }

  public get classImports(): string[] {
    return [];
  }

  public get tsOffset(): string {
    return this.previousValueOffset ? "offset" : this.offset;
  }

  public get tsGetter(): string {
    return "getError!?";
  }

  public getSetter(_propOverride?: string): string {
    return "writeError!?";
  }

  public get tsLabel(): string {
    return this.enumName ? `${this.name}Label` : this.name;
  }

  public get arrayLength(): string {
    if (this.arrayLengthExpression) {
      return `this.${this.arrayLengthExpression.replace("-", ".")}`;
    }
    return this.arrayLengthValue.toString(10);
  }

  public get typeLength(): string {
    if (this.typeLengthExpression) {
      return `t.${this.typeLengthExpression}`;
    }
    return this.baseSize.toString(10);
  }

  // TODO turn type|array length expressions into property expressions at write time: string[]
}

export class PropShort extends Prop {
  public baseSize = 2;

  public get tsGetter(): string {
    return `getShort(hex, ${this.isArray ? "offset" : this.tsOffset})`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeShort(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["getShort", "writeShort"];
  }
}

export class PropByte extends Prop {
  public get tsGetter(): string {
    return `getByte(hex, ${this.isArray ? "offset" : this.tsOffset})`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeByte(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["getByte", "writeByte"];
  }
}

export class PropBool extends Prop {
  public get tsType(): string {
    return "boolean";
  }

  public get tsGetter(): string {
    return `getBool(hex, ${this.isArray ? "offset" : this.tsOffset})`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeBool(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["getBool", "writeBool"];
  }
}

export class PropSByte extends Prop {
  public get tsGetter(): string {
    return `getSByte(hex, ${this.isArray ? "offset" : this.tsOffset})`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeSByte(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["getSByte", "writeSByte"];
  }
}

export class PropInt extends Prop {
  public baseSize = 4;

  public get tsGetter(): string {
    return `getInt(hex, ${this.isArray ? "offset" : this.tsOffset})`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeInt(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["getInt", "writeInt"];
  }
}

export class PropChar extends Prop {
  public get tsType(): string {
    return "string";
  }

  public get tsGetter(): string {
    const len = this.typeLengthExpression ? `this.${this.typeLengthExpression}` : this.typeLength;

    return `getChar(hex, ${this.isArray ? "offset" : this.tsOffset}, ${len})`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeChar(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["getChar", "writeChar"];
  }
}

export class PropStr extends Prop {
  public baseSize = 0;

  public get tsType(): string {
    return "string";
  }

  public get tsGetter(): string {
    return `getString(hex, ${this.isArray ? "offset" : this.tsOffset})`;
  }

  public get typeLength(): string {
    return this.isArray ? "t.length" : `this.${this.name}.length`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeString(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["getString", "writeString"];
  }
}

export class PropObject extends Prop {
  public baseSize = 0;
  public structName: string;
  public get typeLength(): string {
    return this.isArray ? "t.getLength()" : `this.${this.name}.getLength()`;
  }

  public get tsType(): string {
    return this.structName;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeObject(hex, ${p}, ${this.tsOffset})`;
  }

  public get hexImports(): string[] {
    return ["writeObject"];
  }

  public get classImports(): string[] {
    return [this.tsType];
  }

  public prepare(structs: { [key: string]: Struct }): void {
    // do nothing except if object
    const struct = structs[this.structName];
    if (struct && struct.size) {
      this.baseSize = struct.size;
    }
    if (!struct) {
      console.warn("couldnt load data for type ", this.structName);
    }
  }

  public getFieldProps(constantLookup: object, plt: string): object {
    const sup = super.getFieldProps(constantLookup, plt);
    const kebab = lodash.kebabCase(this.structName);
    const componentTag = `pyrite-${plt}-${kebab.replace(plt, "")}`.toLowerCase();
    const componentProp = kebab.toLowerCase();
    return { ...sup, componentTag, componentProp };
  }
}

export class PropAny extends Prop {
  public baseSize = 0;
  public hexGetter = "undefined";

  public get tsGetter(): string {
    return `undefined`;
  }

  public get tsType(): string {
    return "any";
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.name}`;
    return `writeObject(hex, ${p}, ${this.tsOffset})`;
  }

  public getFunctionStubs(): string[] {
    return [`load${this.name}()`, `write${this.name}()`];
  }
}

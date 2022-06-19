import { Struct } from "./struct";

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
        this.baseSize = 0;
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
      return expr && expr.endsWith("()");
    });
  }

  public prepare(_structs: { [key: string]: Struct }): void {
    // do nothing except if object
  }
}

export class PropShort extends Prop {
  public baseSize = 2;
  public hexGetter = "getShort";
  public hexSetter = "writeShort";
}

export class PropUShort extends Prop {
  public baseSize = 2;
  public hexGetter = "getUShort";
  public hexSetter = "writeUShort";
}

export class PropByte extends Prop {
  public hexGetter = "getByte";
  public hexSetter = "writeByte";
}

export class PropBool extends Prop {
  public hexGetter = "getBool";
  public hexSetter = "writeBool";
}

export class PropSByte extends Prop {
  public hexGetter = "getSByte";
  public hexSetter = "writeSByte";
}

export class PropInt extends Prop {
  public baseSize = 4;
  public hexGetter = "getInt";
  public hexSetter = "writeInt";
}

export class PropChar extends Prop {
  public hexGetter = "getChar";
  public hexSetter = "writeChar";
}

export class PropStr extends Prop {
  public baseSize = 0;
  public hexGetter = "getString";
  public hexSetter = "writeString";
}

export class PropObject extends Prop {
  public baseSize = 0;
  public structName: string;
  public hexGetter = "";
  public hexSetter = "writeObject";

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
}

export class PropAny extends Prop {
  public baseSize = 0;
  public hexSetter = "writeObject";

  public getFunctionStubs(): string[] {
    return [`load${this.name}()`, `write${this.name}()`];
  }
}

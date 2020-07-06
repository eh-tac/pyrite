import { Struct } from "./struct";

export type PropType = "SHORT" | "BYTE" | "BOOL" | "SBYTE" | "INT" | "STR" | "CHAR" | string;

export class Prop {
  public baseSize = 1;
  public typeLengthExpression = "";
  public arrayLength: number;
  public arrayLengthExpression = "";
  public reservedValue?: number;
  public enumName: string = "";
  public comment: string = "";

  constructor(public offset: string, public name: string, public type: PropType) {}

  public get size(): number {
    const mult = this.isArray ? this.arrayLength : 1;
    return this.baseSize * mult;
  }

  public get isArray(): boolean {
    return this.arrayLength !== undefined || !!this.arrayLengthExpression;
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

  public handleTypeLength(lengthStr: string): void {
    if (!lengthStr) {
      return;
    }

    const lengthInt = parseInt(lengthStr);
    if (isNaN(lengthInt)) {
      this.typeLengthExpression = lengthStr;
    } else {
      this.baseSize = lengthInt;
    }
  }

  public handleArrayLength(lengthStr: string): void {
    if (!lengthStr) {
      return;
    }

    const lengthInt = parseInt(lengthStr);
    if (isNaN(lengthInt)) {
      this.arrayLengthExpression = lengthStr;
    } else {
      this.arrayLength = lengthInt;
    }
  }

  public handleRest(restStr: string): void {
    if (!restStr) {
      return;
    }

    const resv = restStr.match(/Reserved\((\w*)\)/);
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

  public getFunctionStubs(): string[] {
    return [this.typeLengthExpression, this.arrayLengthExpression].filter((expr: string): boolean => {
      return expr && expr.substr(-2, 2) === "()";
    });
  }

  // TODO turn type|array length expressions into property expressions at write time: string[]
}

export class PropShort extends Prop {
  public baseSize = 2;
}

export class PropByte extends Prop {}

export class PropBool extends Prop {}

export class PropSByte extends Prop {}

export class PropInt extends Prop {
  public baseSize = 4;
}

export class PropChar extends Prop {}

export class PropStr extends Prop {}

export class PropObject extends Prop {
  public structName: string;
}

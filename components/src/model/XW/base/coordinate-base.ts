import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class CoordinateBase extends PyriteBase implements Byteable {
  public readonly COORDINATELENGTH: number = 6;
  public X: number;
  public Y: number;
  public Z: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.X = getShort(hex, 0x00);
    this.Y = getShort(hex, 0x02);
    this.Z = getShort(hex, 0x04);
    
  }
  
  public toJSON(): object {
    return {
      X: this.X,
      Y: this.Y,
      Z: this.Z
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.X, 0x00);
    writeShort(hex, this.Y, 0x02);
    writeShort(hex, this.Z, 0x04);

    return hex;
  }
  
  
  public getLength(): number {
    return this.COORDINATELENGTH;
  }
}
import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BriefingHeaderBase extends PyriteBase implements Byteable {
  public readonly BRIEFINGHEADERLENGTH: number = 6;
  public PlatformID: number; //(2)
  public IconCount: number;
  public CoordinateCount: number;
  
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.PlatformID = getShort(hex, 0x00);
    this.IconCount = getShort(hex, 0x02);
    this.CoordinateCount = getShort(hex, 0x04);
    
  }
  
  public toJSON(): Record<string, unknown> | string {
    return {
      PlatformID: this.PlatformID,
      IconCount: this.IconCount,
      CoordinateCount: this.CoordinateCount,
    };
  }
  
  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.PlatformID, 0x00);
    writeShort(hex, this.IconCount, 0x02);
    writeShort(hex, this.CoordinateCount, 0x04);

    return hex;
  }
  
  
  public getLength(): number {
    return this.BRIEFINGHEADERLENGTH;
  }
}
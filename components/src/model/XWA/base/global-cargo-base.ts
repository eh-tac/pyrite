import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getString, writeBool, writeByte, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GlobalCargoBase extends PyriteBase implements Byteable {
  public readonly GLOBALCARGOLENGTH: number = 140;
  public Cargo: string;
  public Unknown1: boolean;
  public Unknown2: number;
  public Unknown3: number;
  public Unknown4: number;
  public Unknown5: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Cargo = getString(hex, 0x00, 64);
    this.Unknown1 = getBool(hex, 0x44);
    this.Unknown2 = getByte(hex, 0x48);
    this.Unknown3 = getByte(hex, 0x49);
    this.Unknown4 = getByte(hex, 0x4A);
    this.Unknown5 = getByte(hex, 0x4B);
    
  }
  
  public toJSON(): object {
    return {
      Cargo: this.Cargo,
      Unknown1: this.Unknown1,
      Unknown2: this.Unknown2,
      Unknown3: this.Unknown3,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeString(hex, this.Cargo, 0x00);
    writeBool(hex, this.Unknown1, 0x44);
    writeByte(hex, this.Unknown2, 0x48);
    writeByte(hex, this.Unknown3, 0x49);
    writeByte(hex, this.Unknown4, 0x4A);
    writeByte(hex, this.Unknown5, 0x4B);

    return hex;
  }
  
  
  public getLength(): number {
    return this.GLOBALCARGOLENGTH;
  }
}
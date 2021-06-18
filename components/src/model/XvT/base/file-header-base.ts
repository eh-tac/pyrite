import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getChar, getShort, writeBool, writeByte, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public readonly FILEHEADERLENGTH: number = 164;
  public PlatformID: number;
  public NumFGs: number;
  public NumMessages: number;
  public Unknown1: number;
  public Unknown2: number;
  public Unknown3: boolean;
  public Unknown4: string;
  public Unknown5: string;
  public MissionType: number;
  public Unknown6: boolean;
  public TimeLimitMinutes: number;
  public TimeLimitSeconds: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.PlatformID = getShort(hex, 0x00);
    this.NumFGs = getShort(hex, 0x02);
    this.NumMessages = getShort(hex, 0x04);
    this.Unknown1 = getByte(hex, 0x06);
    this.Unknown2 = getByte(hex, 0x08);
    this.Unknown3 = getBool(hex, 0x0B);
    this.Unknown4 = getChar(hex, 0x28, 16);
    this.Unknown5 = getChar(hex, 0x50, 16);
    this.MissionType = getByte(hex, 0x64);
    this.Unknown6 = getBool(hex, 0x65);
    this.TimeLimitMinutes = getByte(hex, 0x66);
    this.TimeLimitSeconds = getByte(hex, 0x67);
    
  }
  
  public toJSON(): object {
    return {
      PlatformID: this.PlatformID,
      NumFGs: this.NumFGs,
      NumMessages: this.NumMessages,
      Unknown1: this.Unknown1,
      Unknown2: this.Unknown2,
      Unknown3: this.Unknown3,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5,
      MissionType: this.MissionType,
      Unknown6: this.Unknown6,
      TimeLimitMinutes: this.TimeLimitMinutes,
      TimeLimitSeconds: this.TimeLimitSeconds
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.PlatformID, 0x00);
    writeShort(hex, this.NumFGs, 0x02);
    writeShort(hex, this.NumMessages, 0x04);
    writeByte(hex, this.Unknown1, 0x06);
    writeByte(hex, this.Unknown2, 0x08);
    writeBool(hex, this.Unknown3, 0x0B);
    writeChar(hex, this.Unknown4, 0x28);
    writeChar(hex, this.Unknown5, 0x50);
    writeByte(hex, this.MissionType, 0x64);
    writeBool(hex, this.Unknown6, 0x65);
    writeByte(hex, this.TimeLimitMinutes, 0x66);
    writeByte(hex, this.TimeLimitSeconds, 0x67);

    return hex;
  }
  
  
  public getLength(): number {
    return this.FILEHEADERLENGTH;
  }
}
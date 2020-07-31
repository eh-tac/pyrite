import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getChar, getShort, writeBool, writeByte, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public readonly FILEHEADERLENGTH: number = 458;
  public readonly PlatformID: number = -1;
  public NumFGs: number;
  public NumMessages: number;
  public readonly NumGGs: number = 3; //might be # of GlobalGoals
  public Unknown1: number;
  public Unknown2: boolean;
  public BriefingOfficers: number;
  public CapturedOnEject: boolean;
  public EndOfMissionMessages: string[];
  public OtherIffNames: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    // static prop PlatformID
    this.NumFGs = getShort(hex, 0x002);
    this.NumMessages = getShort(hex, 0x004);
    // static prop NumGGs
    this.Unknown1 = getByte(hex, 0x008);
    this.Unknown2 = getBool(hex, 0x009);
    this.BriefingOfficers = getByte(hex, 0x00A);
    this.CapturedOnEject = getBool(hex, 0x00D);
    this.EndOfMissionMessages = [];
    offset = 0x018;
    for (let i = 0; i < 6; i++) {
      const t = getChar(hex, offset, 64);
      this.EndOfMissionMessages.push(t);
      offset += 64;
    }
    this.OtherIffNames = [];
    offset = 0x19A;
    for (let i = 0; i < 4; i++) {
      const t = getChar(hex, offset, 12);
      this.OtherIffNames.push(t);
      offset += 12;
    }
    
  }
  
  public toJSON(): object {
    return {
      NumFGs: this.NumFGs,
      NumMessages: this.NumMessages,
      Unknown1: this.Unknown1,
      Unknown2: this.Unknown2,
      BriefingOfficers: this.BriefingOfficersLabel,
      CapturedOnEject: this.CapturedOnEject,
      EndOfMissionMessages: this.EndOfMissionMessages,
      OtherIffNames: this.OtherIffNames
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, -1, 0x000);
    writeShort(hex, this.NumFGs, 0x002);
    writeShort(hex, this.NumMessages, 0x004);
    writeShort(hex, 3, 0x006);
    writeByte(hex, this.Unknown1, 0x008);
    writeBool(hex, this.Unknown2, 0x009);
    writeByte(hex, this.BriefingOfficers, 0x00A);
    writeBool(hex, this.CapturedOnEject, 0x00D);
    offset = 0x018;
    for (let i = 0; i < 6; i++) {
      const t = this.EndOfMissionMessages[i];
      writeChar(hex, t, offset);
      offset += 64;
    }
    offset = 0x19A;
    for (let i = 0; i < 4; i++) {
      const t = this.OtherIffNames[i];
      writeChar(hex, t, offset);
      offset += 12;
    }

    return hex;
  }
  
  public get BriefingOfficersLabel(): string {
    return Constants.BRIEFINGOFFICERS[this.BriefingOfficers] || "Unknown";
  }
  
  public getLength(): number {
    return this.FILEHEADERLENGTH;
  }
}
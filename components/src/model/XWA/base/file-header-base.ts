import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { GlobalCargo } from "../global-cargo";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getByte, getShort, getString, writeBool, writeByte, writeObject, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public readonly FILEHEADERLENGTH: number = 9200;
  public PlatformID: number; //(0x20)
  public NumFGs: number;
  public NumMessages: number;
  public Unknown1: boolean;
  public Unknown2: boolean;
  public IffNames: string[];
  public RegionNames: string[];
  public GlobalCargo: GlobalCargo[];
  public GlobalGroupNames: string[];
  public Hangar: number;
  public TimeLimitMinutes: number;
  public EndMissionWhenComplete: boolean;
  public BriefingOfficer: number;
  public BriefingLogo: number;
  public Unknown3: number;
  public Unknown4: number;
  public Unknown5: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.PlatformID = getShort(hex, 0x0000);
    this.NumFGs = getShort(hex, 0x0002);
    this.NumMessages = getShort(hex, 0x0004);
    this.Unknown1 = getBool(hex, 0x0008);
    this.Unknown2 = getBool(hex, 0x000B);
    this.IffNames = [];
    offset = 0x0014;
    for (let i = 0; i < 4; i++) {
      const t = getString(hex, offset, 20);
      this.IffNames.push(t);
      offset += t.length + 1;
    }
    this.RegionNames = [];
    offset = 0x0064;
    for (let i = 0; i < 4; i++) {
      const t = getString(hex, offset, 132);
      this.RegionNames.push(t);
      offset += t.length + 1;
    }
    this.GlobalCargo = [];
    offset = 0x0274;
    for (let i = 0; i < 16; i++) {
      const t = new GlobalCargo(hex.slice(offset), this.TIE);
      this.GlobalCargo.push(t);
      offset += t.getLength();
    }
    this.GlobalGroupNames = [];
    offset = 0x0B34;
    for (let i = 0; i < 16; i++) {
      const t = getString(hex, offset, 87);
      this.GlobalGroupNames.push(t);
      offset += t.length + 1;
    }
    this.Hangar = getByte(hex, 0x23AC);
    this.TimeLimitMinutes = getByte(hex, 0x23AE);
    this.EndMissionWhenComplete = getBool(hex, 0x23AF);
    this.BriefingOfficer = getByte(hex, 0x23B0);
    this.BriefingLogo = getByte(hex, 0x23B1);
    this.Unknown3 = getByte(hex, 0x23B3);
    this.Unknown4 = getByte(hex, 0x23B4);
    this.Unknown5 = getByte(hex, 0x23B5);
    
  }
  
  public toJSON(): object {
    return {
      PlatformID: this.PlatformID,
      NumFGs: this.NumFGs,
      NumMessages: this.NumMessages,
      Unknown1: this.Unknown1,
      Unknown2: this.Unknown2,
      IffNames: this.IffNames,
      RegionNames: this.RegionNames,
      GlobalCargo: this.GlobalCargo,
      GlobalGroupNames: this.GlobalGroupNames,
      Hangar: this.HangarLabel,
      TimeLimitMinutes: this.TimeLimitMinutes,
      EndMissionWhenComplete: this.EndMissionWhenComplete,
      BriefingOfficer: this.BriefingOfficerLabel,
      BriefingLogo: this.BriefingLogoLabel,
      Unknown3: this.Unknown3,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.PlatformID, 0x0000);
    writeShort(hex, this.NumFGs, 0x0002);
    writeShort(hex, this.NumMessages, 0x0004);
    writeBool(hex, this.Unknown1, 0x0008);
    writeBool(hex, this.Unknown2, 0x000B);
    offset = 0x0014;
    for (let i = 0; i < 4; i++) {
      const t = this.IffNames[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    offset = 0x0064;
    for (let i = 0; i < 4; i++) {
      const t = this.RegionNames[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    offset = 0x0274;
    for (let i = 0; i < 16; i++) {
      const t = this.GlobalCargo[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x0B34;
    for (let i = 0; i < 16; i++) {
      const t = this.GlobalGroupNames[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    writeByte(hex, this.Hangar, 0x23AC);
    writeByte(hex, this.TimeLimitMinutes, 0x23AE);
    writeBool(hex, this.EndMissionWhenComplete, 0x23AF);
    writeByte(hex, this.BriefingOfficer, 0x23B0);
    writeByte(hex, this.BriefingLogo, 0x23B1);
    writeByte(hex, this.Unknown3, 0x23B3);
    writeByte(hex, this.Unknown4, 0x23B4);
    writeByte(hex, this.Unknown5, 0x23B5);

    return hex;
  }
  
  public get HangarLabel(): string {
    return Constants.HANGAR[this.Hangar] || "Unknown";
  }

  public get BriefingOfficerLabel(): string {
    return Constants.BRIEFINGOFFICER[this.BriefingOfficer] || "Unknown";
  }

  public get BriefingLogoLabel(): string {
    return Constants.BRIEFINGLOGO[this.BriefingLogo] || "Unknown";
  }
  
  public getLength(): number {
    return this.FILEHEADERLENGTH;
  }
}
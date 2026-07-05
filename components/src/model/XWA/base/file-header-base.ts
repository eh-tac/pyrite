import { Byteable } from "../../../byteable";
import { BriefingLogo, BriefingOfficer, Constants, Hangar } from "../constants";
import { GlobalCargo } from "../global-cargo";
import { GlobalUnit } from "../global-unit";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Region } from "../region";
import {
  getBool,
  getByte,
  getShort,
  getString,
  writeBool,
  writeByte,
  writeObject,
  writeShort,
  writeString,
} from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public readonly FILEHEADERLENGTH: number = 9200;
  public PlatformID: number; //(0x20)
  public NumFGs: number;
  public NumMessages: number;
  public TimeLimitMin: number;
  public TimeLimitSec: number;
  public WinType: number; //(was Unknown1, default 1)
  public Backdrop: number;
  public Rescue: number;
  public AllWayShown: number; //(was Unknown2, probably editor only)
  public Vars: number[];
  public IffNames: string[];
  public Regions: Region[];
  public GlobalCargo: GlobalCargo[];
  public GlobalGroups: GlobalUnit[];
  public GlobalUnits: GlobalUnit[];
  public Hangar: Hangar;
  public GoalsUnimportant: boolean;
  public TimeLimitMinutes: number;
  public EndMissionWhenComplete: boolean;
  public BriefingOfficer: BriefingOfficer;
  public BriefingLogo: BriefingLogo; //(also known as CommandOfficer)
  public BriefingOfficerEntryLine: number;
  public SecondaryVersion: number; //(0x62 'b', was Unknown3, might be editor only)
  public WinOfficer: BriefingOfficer; //(was Unknown4)
  public FailOfficer: BriefingOfficer; //(was Unknown5)

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.PlatformID = getShort(hex, 0x0000);
    this.NumFGs = getShort(hex, 0x0002);
    this.NumMessages = getShort(hex, 0x0004);
    this.TimeLimitMin = getByte(hex, 0x0006);
    this.TimeLimitSec = getByte(hex, 0x0007);
    this.WinType = getByte(hex, 0x0008);
    this.Backdrop = getByte(hex, 0x0009);
    this.Rescue = getByte(hex, 0x000a);
    this.AllWayShown = getByte(hex, 0x000b);
    this.Vars = [];
    offset = 0x000c;
    for (let i = 0; i < 8; i++) {
      const t = getByte(hex, offset);
      this.Vars.push(t);
      offset += 1;
    }
    this.IffNames = [];
    offset = 0x0014;
    for (let i = 0; i < 4; i++) {
      const t = getString(hex, offset, 20);
      this.IffNames.push(t);
      offset += 20;
    }
    this.Regions = [];
    offset = 0x0064;
    for (let i = 0; i < 4; i++) {
      const t = new Region(hex.slice(offset), this.TIE);
      this.Regions.push(t);
      offset += t.getLength();
    }
    this.GlobalCargo = [];
    offset = 0x0274;
    for (let i = 0; i < 16; i++) {
      const t = new GlobalCargo(hex.slice(offset), this.TIE);
      this.GlobalCargo.push(t);
      offset += t.getLength();
    }
    this.GlobalGroups = [];
    offset = 0x0b34;
    for (let i = 0; i < 32; i++) {
      const t = new GlobalUnit(hex.slice(offset), this.TIE);
      this.GlobalGroups.push(t);
      offset += t.getLength();
    }
    this.GlobalUnits = [];
    offset = 0x1614;
    for (let i = 0; i < 40; i++) {
      const t = new GlobalUnit(hex.slice(offset), this.TIE);
      this.GlobalUnits.push(t);
      offset += t.getLength();
    }
    this.Hangar = getByte(hex, 0x23ac) as Hangar;
    this.GoalsUnimportant = getBool(hex, 0x23ad);
    this.TimeLimitMinutes = getByte(hex, 0x23ae);
    this.EndMissionWhenComplete = getBool(hex, 0x23af);
    this.BriefingOfficer = getByte(hex, 0x23b0) as BriefingOfficer;
    this.BriefingLogo = getByte(hex, 0x23b1) as BriefingLogo;
    this.BriefingOfficerEntryLine = getByte(hex, 0x23b2);
    this.SecondaryVersion = getByte(hex, 0x23b3);
    this.WinOfficer = getByte(hex, 0x23b4) as BriefingOfficer;
    this.FailOfficer = getByte(hex, 0x23b5) as BriefingOfficer;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      PlatformID: this.PlatformID,
      NumFGs: this.NumFGs,
      NumMessages: this.NumMessages,
      TimeLimitMin: this.TimeLimitMin,
      TimeLimitSec: this.TimeLimitSec,
      WinType: this.WinType,
      Backdrop: this.Backdrop,
      Rescue: this.Rescue,
      AllWayShown: this.AllWayShown,
      Vars: this.Vars,
      IffNames: this.IffNames,
      Regions: this.Regions.map((t) => t.toJSON()),
      GlobalCargo: this.GlobalCargo.map((t) => t.toJSON()),
      GlobalGroups: this.GlobalGroups.map((t) => t.toJSON()),
      GlobalUnits: this.GlobalUnits.map((t) => t.toJSON()),
      Hangar: this.HangarLabel,
      GoalsUnimportant: this.GoalsUnimportant,
      TimeLimitMinutes: this.TimeLimitMinutes,
      EndMissionWhenComplete: this.EndMissionWhenComplete,
      BriefingOfficer: this.BriefingOfficerLabel,
      BriefingLogo: this.BriefingLogoLabel,
      BriefingOfficerEntryLine: this.BriefingOfficerEntryLine,
      SecondaryVersion: this.SecondaryVersion,
      WinOfficer: this.WinOfficerLabel,
      FailOfficer: this.FailOfficerLabel,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.PlatformID, 0x0000);
    writeShort(hex, this.NumFGs, 0x0002);
    writeShort(hex, this.NumMessages, 0x0004);
    writeByte(hex, this.TimeLimitMin, 0x0006);
    writeByte(hex, this.TimeLimitSec, 0x0007);
    writeByte(hex, this.WinType, 0x0008);
    writeByte(hex, this.Backdrop, 0x0009);
    writeByte(hex, this.Rescue, 0x000a);
    writeByte(hex, this.AllWayShown, 0x000b);
    offset = 0x000c;
    for (let i = 0; i < this.Vars.length; i++) {
      const t = this.Vars[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x0014;
    for (let i = 0; i < this.IffNames.length; i++) {
      const t = this.IffNames[i];
      writeString(hex, t, offset, 20);
      offset += 20;
    }
    offset = 0x0064;
    for (let i = 0; i < this.Regions.length; i++) {
      const t = this.Regions[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x0274;
    for (let i = 0; i < this.GlobalCargo.length; i++) {
      const t = this.GlobalCargo[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x0b34;
    for (let i = 0; i < this.GlobalGroups.length; i++) {
      const t = this.GlobalGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x1614;
    for (let i = 0; i < this.GlobalUnits.length; i++) {
      const t = this.GlobalUnits[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeByte(hex, this.Hangar, 0x23ac);
    writeBool(hex, this.GoalsUnimportant, 0x23ad);
    writeByte(hex, this.TimeLimitMinutes, 0x23ae);
    writeBool(hex, this.EndMissionWhenComplete, 0x23af);
    writeByte(hex, this.BriefingOfficer, 0x23b0);
    writeByte(hex, this.BriefingLogo, 0x23b1);
    writeByte(hex, this.BriefingOfficerEntryLine, 0x23b2);
    writeByte(hex, this.SecondaryVersion, 0x23b3);
    writeByte(hex, this.WinOfficer, 0x23b4);
    writeByte(hex, this.FailOfficer, 0x23b5);

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

  public get WinOfficerLabel(): string {
    return Constants.BRIEFINGOFFICER[this.WinOfficer] || "Unknown";
  }

  public get FailOfficerLabel(): string {
    return Constants.BRIEFINGOFFICER[this.FailOfficer] || "Unknown";
  }

  public getLength(): number {
    return this.FILEHEADERLENGTH;
  }
}

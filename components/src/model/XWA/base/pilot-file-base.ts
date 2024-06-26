import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { MissionData } from "../mission-data";
import { getChar, getInt, writeChar, writeInt, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PilotFileBase extends PyriteBase implements Byteable {
  public readonly PILOTFILELENGTH: number = 152076;
  public Name: string;
  public TotalScore: number;
  public MPName: string;
  public MPGameName: string;
  public ToNextRanking: number;
  public TourOfDutyScore: number;
  public AzzameenScore: number;
  public SimulatorScore: number;
  public TourOfDutyKills: number[];
  public AzzameenKills: number[];
  public SimulatorKills: number[];
  public TourOfDutyPartials: number[];
  public AzzameenPartials: number[];
  public SimulatorPartials: number[];
  public LasersHit: number;
  public LasersFired: number;
  public WarheadsHit: number;
  public WarheadsFired: number;
  public CraftLosses: number;
  public MissionData: MissionData[];
  public CurrentRank: number;
  public CurrentMedal: number;
  public BonusTen: number;

  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getChar(hex, 0x00, 14);
    this.TotalScore = getInt(hex, 0x0e);
    this.MPName = getChar(hex, 0x4a, 32);
    this.MPGameName = getChar(hex, 0x6a, 32);
    this.ToNextRanking = getInt(hex, 0x9a);
    this.TourOfDutyScore = getInt(hex, 0x9e);
    this.AzzameenScore = getInt(hex, 0xa2);
    this.SimulatorScore = getInt(hex, 0xa6);
    this.TourOfDutyKills = [];
    offset = 0xd2;
    for (let i = 0; i < 256; i++) {
      const t = getInt(hex, offset);
      this.TourOfDutyKills.push(t);
      offset += 4;
    }
    this.AzzameenKills = [];
    offset = 0x8ce;
    for (let i = 0; i < 256; i++) {
      const t = getInt(hex, offset);
      this.AzzameenKills.push(t);
      offset += 4;
    }
    this.SimulatorKills = [];
    offset = 0x10d2;
    for (let i = 0; i < 256; i++) {
      const t = getInt(hex, offset);
      this.SimulatorKills.push(t);
      offset += 4;
    }
    this.TourOfDutyPartials = [];
    offset = 0x18d2;
    for (let i = 0; i < 256; i++) {
      const t = getInt(hex, offset);
      this.TourOfDutyPartials.push(t);
      offset += 4;
    }
    this.AzzameenPartials = [];
    offset = 0x20ce;
    for (let i = 0; i < 256; i++) {
      const t = getInt(hex, offset);
      this.AzzameenPartials.push(t);
      offset += 4;
    }
    this.SimulatorPartials = [];
    offset = 0x28d2;
    for (let i = 0; i < 256; i++) {
      const t = getInt(hex, offset);
      this.SimulatorPartials.push(t);
      offset += 4;
    }
    this.LasersHit = getInt(hex, 0x4d36);
    this.LasersFired = getInt(hex, 0x4d42);
    this.WarheadsHit = getInt(hex, 0x4d4e);
    this.WarheadsFired = getInt(hex, 0x4d5a);
    this.CraftLosses = getInt(hex, 0x4d66);
    this.MissionData = [];
    offset = 0xacfa;
    for (let i = 0; i < 200; i++) {
      const t = new MissionData(hex.slice(offset), this.TIE);
      this.MissionData.push(t);
      offset += t.getLength();
    }
    this.CurrentRank = getInt(hex, 0x10ea2);
    this.CurrentMedal = getInt(hex, 0x10ea6);
    this.BonusTen = getInt(hex, 0x1144e);
  }

  public toJSON(): object {
    return {
      Name: this.Name,
      TotalScore: this.TotalScore,
      MPName: this.MPName,
      MPGameName: this.MPGameName,
      ToNextRanking: this.ToNextRanking,
      TourOfDutyScore: this.TourOfDutyScore,
      AzzameenScore: this.AzzameenScore,
      SimulatorScore: this.SimulatorScore,
      TourOfDutyKills: this.TourOfDutyKills,
      AzzameenKills: this.AzzameenKills,
      SimulatorKills: this.SimulatorKills,
      TourOfDutyPartials: this.TourOfDutyPartials,
      AzzameenPartials: this.AzzameenPartials,
      SimulatorPartials: this.SimulatorPartials,
      LasersHit: this.LasersHit,
      LasersFired: this.LasersFired,
      WarheadsHit: this.WarheadsHit,
      WarheadsFired: this.WarheadsFired,
      CraftLosses: this.CraftLosses,
      MissionData: this.MissionData,
      CurrentRank: this.CurrentRank,
      CurrentMedal: this.CurrentMedal,
      BonusTen: this.BonusTen
    };
  }

  public toHexString(): string {
    let hex: string = "";
    let offset = 0;

    writeChar(hex, this.Name, 0x00);
    writeInt(hex, this.TotalScore, 0x0e);
    writeChar(hex, this.MPName, 0x4a);
    writeChar(hex, this.MPGameName, 0x6a);
    writeInt(hex, this.ToNextRanking, 0x9a);
    writeInt(hex, this.TourOfDutyScore, 0x9e);
    writeInt(hex, this.AzzameenScore, 0xa2);
    writeInt(hex, this.SimulatorScore, 0xa6);
    offset = 0xd2;
    for (let i = 0; i < 256; i++) {
      const t = this.TourOfDutyKills[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x8ce;
    for (let i = 0; i < 256; i++) {
      const t = this.AzzameenKills[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x10d2;
    for (let i = 0; i < 256; i++) {
      const t = this.SimulatorKills[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x18d2;
    for (let i = 0; i < 256; i++) {
      const t = this.TourOfDutyPartials[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x20ce;
    for (let i = 0; i < 256; i++) {
      const t = this.AzzameenPartials[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x28d2;
    for (let i = 0; i < 256; i++) {
      const t = this.SimulatorPartials[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeInt(hex, this.LasersHit, 0x4d36);
    writeInt(hex, this.LasersFired, 0x4d42);
    writeInt(hex, this.WarheadsHit, 0x4d4e);
    writeInt(hex, this.WarheadsFired, 0x4d5a);
    writeInt(hex, this.CraftLosses, 0x4d66);
    offset = 0xacfa;
    for (let i = 0; i < 100; i++) {
      const t = this.MissionData[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeInt(hex, this.CurrentRank, 0x10ea2);
    writeInt(hex, this.CurrentMedal, 0x10ea6);
    writeInt(hex, this.BonusTen, 0x1144e);

    return hex;
  }

  public getLength(): number {
    return this.PILOTFILELENGTH;
  }
}

import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import {
  AbortTrigger,
  ArrivalDifficulty,
  Beam,
  Constants,
  CraftType,
  Formation,
  GroupAI,
  Markings,
  Status,
  Warhead
} from '../constants';
import { GoalFG } from '../goal-fg';
import { Order } from '../order';
import { Trigger } from '../trigger';
import { Waypt } from '../waypt';
import {
  getBool,
  getByte,
  getChar,
  getSByte,
  writeBool,
  writeByte,
  writeChar,
  writeObject,
  writeSByte
} from '@pyrite/core';
export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public readonly FLIGHTGROUPLENGTH: number = 292;
  public Name: string;
  public Pilot: string;
  public Cargo: string;
  public SpecialCargo: string;
  public SpecialCargoCraft: number;
  public RandomSpecialCargoCraft: boolean;
  public CraftType: CraftType;
  public NumberOfCraft: number;
  public Status: Status;
  public Warhead: Warhead;
  public Beam: Beam;
  public Iff: number;
  public GroupAI: GroupAI;
  public Markings: Markings;
  public ObeyPlayerOrders: boolean;
  public readonly Reserved1: number = 0; //Unknown1 in TFW
  public Formation: Formation;
  public FormationSpacing: number; //Unknown2
  public GlobalGroup: number; //Unknown3
  public LeaderSpacing: number; //Unknown4
  public NumberOfWaves: number;
  public Unknown5: number;
  public PlayerCraft: number;
  public Yaw: number; //Unknown6
  public Pitch: number; //Unknown7
  public Roll: number; //Unknown8
  public Unknown9: boolean;
  public Unknown10: number;
  public readonly Reserved2: number = 0; //Unknown11
  public ArrivalDifficulty: ArrivalDifficulty;
  public Arrival1: Trigger;
  public Arrival2: Trigger;
  public Arrival1OrArrival2: boolean;
  public readonly Reserved3: number = 0; //Unknown12
  public ArrivalDelayMinutes: number;
  public ArrivalDelaySeconds: number;
  public Departure: Trigger;
  public DepartureDelayMinutes: number; //Unknown13
  public DepartureDelatSeconds: number; //Unknown14
  public AbortTrigger: AbortTrigger;
  public readonly Reserved4: number = 0; //Unknown15
  public Unknown16: number;
  public readonly Reserved5: number = 0; //Unknown17
  public ArrivalMothership: number;
  public ArriveViaMothership: boolean;
  public DepartureMothership: number;
  public DepartViaMothership: boolean;
  public AlternateArrivalMothership: number;
  public AlternateArriveViaMothership: boolean;
  public AlternateDepartureMothership: number;
  public AlternateDepartViaMothership: boolean;
  public Orders: Order[];
  public FlightGroupGoals: GoalFG[];
  public BonusGoalPoints: number;
  public Waypoints: Waypt[];
  public Unknown19: boolean;
  public Unknown20: number;
  public Unknown21: boolean;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getChar(hex, 0x000, 12);
    this.Pilot = getChar(hex, 0x00c, 12);
    this.Cargo = getChar(hex, 0x018, 12);
    this.SpecialCargo = getChar(hex, 0x024, 12);
    this.SpecialCargoCraft = getByte(hex, 0x030);
    this.RandomSpecialCargoCraft = getBool(hex, 0x031);
    this.CraftType = getByte(hex, 0x032) as CraftType;
    this.NumberOfCraft = getByte(hex, 0x033);
    this.Status = getByte(hex, 0x034) as Status;
    this.Warhead = getByte(hex, 0x035) as Warhead;
    this.Beam = getByte(hex, 0x036) as Beam;
    this.Iff = getByte(hex, 0x037);
    this.GroupAI = getByte(hex, 0x038) as GroupAI;
    this.Markings = getByte(hex, 0x039) as Markings;
    this.ObeyPlayerOrders = getBool(hex, 0x03a);
    // static prop Reserved1
    this.Formation = getByte(hex, 0x03c) as Formation;
    this.FormationSpacing = getByte(hex, 0x03d);
    this.GlobalGroup = getByte(hex, 0x03e);
    this.LeaderSpacing = getByte(hex, 0x03f);
    this.NumberOfWaves = getByte(hex, 0x040);
    this.Unknown5 = getByte(hex, 0x041);
    this.PlayerCraft = getByte(hex, 0x042);
    this.Yaw = getByte(hex, 0x043);
    this.Pitch = getByte(hex, 0x044);
    this.Roll = getByte(hex, 0x045);
    this.Unknown9 = getBool(hex, 0x046);
    this.Unknown10 = getByte(hex, 0x047);
    // static prop Reserved2
    this.ArrivalDifficulty = getByte(hex, 0x049) as ArrivalDifficulty;
    this.Arrival1 = new Trigger(hex.slice(0x04a), this.TIE);
    this.Arrival2 = new Trigger(hex.slice(0x04e), this.TIE);
    this.Arrival1OrArrival2 = getBool(hex, 0x052);
    // static prop Reserved3
    this.ArrivalDelayMinutes = getByte(hex, 0x054);
    this.ArrivalDelaySeconds = getByte(hex, 0x055);
    this.Departure = new Trigger(hex.slice(0x056), this.TIE);
    this.DepartureDelayMinutes = getByte(hex, 0x05a);
    this.DepartureDelatSeconds = getByte(hex, 0x05b);
    this.AbortTrigger = getByte(hex, 0x05c) as AbortTrigger;
    // static prop Reserved4
    this.Unknown16 = getByte(hex, 0x05e);
    // static prop Reserved5
    this.ArrivalMothership = getByte(hex, 0x060);
    this.ArriveViaMothership = getBool(hex, 0x061);
    this.DepartureMothership = getByte(hex, 0x062);
    this.DepartViaMothership = getBool(hex, 0x063);
    this.AlternateArrivalMothership = getByte(hex, 0x064);
    this.AlternateArriveViaMothership = getBool(hex, 0x065);
    this.AlternateDepartureMothership = getByte(hex, 0x066);
    this.AlternateDepartViaMothership = getBool(hex, 0x067);
    this.Orders = [];
    offset = 0x068;
    for (let i = 0; i < 3; i++) {
      const t = new Order(hex.slice(offset), this.TIE);
      this.Orders.push(t);
      offset += t.getLength();
    }
    this.FlightGroupGoals = [];
    offset = 0x09e;
    for (let i = 0; i < 4; i++) {
      const t = new GoalFG(hex.slice(offset), this.TIE);
      this.FlightGroupGoals.push(t);
      offset += t.getLength();
    }
    this.BonusGoalPoints = getSByte(hex, 0x0a6);
    this.Waypoints = [];
    offset = 0x0a8;
    for (let i = 0; i < 4; i++) {
      const t = new Waypt(hex.slice(offset), this.TIE);
      this.Waypoints.push(t);
      offset += t.getLength();
    }
    this.Unknown19 = getBool(hex, 0x120);
    this.Unknown20 = getByte(hex, 0x122);
    this.Unknown21 = getBool(hex, 0x123);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Name: this.Name,
      Pilot: this.Pilot,
      Cargo: this.Cargo,
      SpecialCargo: this.SpecialCargo,
      SpecialCargoCraft: this.SpecialCargoCraft,
      RandomSpecialCargoCraft: this.RandomSpecialCargoCraft,
      CraftType: this.CraftTypeLabel,
      NumberOfCraft: this.NumberOfCraft,
      Status: this.StatusLabel,
      Warhead: this.WarheadLabel,
      Beam: this.BeamLabel,
      Iff: this.Iff,
      GroupAI: this.GroupAILabel,
      Markings: this.MarkingsLabel,
      ObeyPlayerOrders: this.ObeyPlayerOrders,
      Formation: this.FormationLabel,
      FormationSpacing: this.FormationSpacing,
      GlobalGroup: this.GlobalGroup,
      LeaderSpacing: this.LeaderSpacing,
      NumberOfWaves: this.NumberOfWaves,
      Unknown5: this.Unknown5,
      PlayerCraft: this.PlayerCraft,
      Yaw: this.Yaw,
      Pitch: this.Pitch,
      Roll: this.Roll,
      Unknown9: this.Unknown9,
      Unknown10: this.Unknown10,
      ArrivalDifficulty: this.ArrivalDifficultyLabel,
      Arrival1: this.Arrival1.toJSON(),
      Arrival2: this.Arrival2.toJSON(),
      Arrival1OrArrival2: this.Arrival1OrArrival2,
      ArrivalDelayMinutes: this.ArrivalDelayMinutes,
      ArrivalDelaySeconds: this.ArrivalDelaySeconds,
      Departure: this.Departure.toJSON(),
      DepartureDelayMinutes: this.DepartureDelayMinutes,
      DepartureDelatSeconds: this.DepartureDelatSeconds,
      AbortTrigger: this.AbortTriggerLabel,
      Unknown16: this.Unknown16,
      ArrivalMothership: this.ArrivalMothership,
      ArriveViaMothership: this.ArriveViaMothership,
      DepartureMothership: this.DepartureMothership,
      DepartViaMothership: this.DepartViaMothership,
      AlternateArrivalMothership: this.AlternateArrivalMothership,
      AlternateArriveViaMothership: this.AlternateArriveViaMothership,
      AlternateDepartureMothership: this.AlternateDepartureMothership,
      AlternateDepartViaMothership: this.AlternateDepartViaMothership,
      Orders: this.Orders.map((t) => t.toJSON()),
      FlightGroupGoals: this.FlightGroupGoals.map((t) => t.toJSON()),
      BonusGoalPoints: this.BonusGoalPoints,
      Waypoints: this.Waypoints.map((t) => t.toJSON()),
      Unknown19: this.Unknown19,
      Unknown20: this.Unknown20,
      Unknown21: this.Unknown21
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeChar(hex, this.Name, 0x000, 12);
    writeChar(hex, this.Pilot, 0x00c, 12);
    writeChar(hex, this.Cargo, 0x018, 12);
    writeChar(hex, this.SpecialCargo, 0x024, 12);
    writeByte(hex, this.SpecialCargoCraft, 0x030);
    writeBool(hex, this.RandomSpecialCargoCraft, 0x031);
    writeByte(hex, this.CraftType, 0x032);
    writeByte(hex, this.NumberOfCraft, 0x033);
    writeByte(hex, this.Status, 0x034);
    writeByte(hex, this.Warhead, 0x035);
    writeByte(hex, this.Beam, 0x036);
    writeByte(hex, this.Iff, 0x037);
    writeByte(hex, this.GroupAI, 0x038);
    writeByte(hex, this.Markings, 0x039);
    writeBool(hex, this.ObeyPlayerOrders, 0x03a);
    writeByte(hex, this.Reserved1, 0x03b);
    writeByte(hex, this.Formation, 0x03c);
    writeByte(hex, this.FormationSpacing, 0x03d);
    writeByte(hex, this.GlobalGroup, 0x03e);
    writeByte(hex, this.LeaderSpacing, 0x03f);
    writeByte(hex, this.NumberOfWaves, 0x040);
    writeByte(hex, this.Unknown5, 0x041);
    writeByte(hex, this.PlayerCraft, 0x042);
    writeByte(hex, this.Yaw, 0x043);
    writeByte(hex, this.Pitch, 0x044);
    writeByte(hex, this.Roll, 0x045);
    writeBool(hex, this.Unknown9, 0x046);
    writeByte(hex, this.Unknown10, 0x047);
    writeByte(hex, this.Reserved2, 0x048);
    writeByte(hex, this.ArrivalDifficulty, 0x049);
    writeObject(hex, this.Arrival1, 0x04a);
    writeObject(hex, this.Arrival2, 0x04e);
    writeBool(hex, this.Arrival1OrArrival2, 0x052);
    writeByte(hex, this.Reserved3, 0x053);
    writeByte(hex, this.ArrivalDelayMinutes, 0x054);
    writeByte(hex, this.ArrivalDelaySeconds, 0x055);
    writeObject(hex, this.Departure, 0x056);
    writeByte(hex, this.DepartureDelayMinutes, 0x05a);
    writeByte(hex, this.DepartureDelatSeconds, 0x05b);
    writeByte(hex, this.AbortTrigger, 0x05c);
    writeByte(hex, this.Reserved4, 0x05d);
    writeByte(hex, this.Unknown16, 0x05e);
    writeByte(hex, this.Reserved5, 0x05f);
    writeByte(hex, this.ArrivalMothership, 0x060);
    writeBool(hex, this.ArriveViaMothership, 0x061);
    writeByte(hex, this.DepartureMothership, 0x062);
    writeBool(hex, this.DepartViaMothership, 0x063);
    writeByte(hex, this.AlternateArrivalMothership, 0x064);
    writeBool(hex, this.AlternateArriveViaMothership, 0x065);
    writeByte(hex, this.AlternateDepartureMothership, 0x066);
    writeBool(hex, this.AlternateDepartViaMothership, 0x067);
    offset = 0x068;
    for (let i = 0; i < this.Orders.length; i++) {
      const t = this.Orders[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x09e;
    for (let i = 0; i < this.FlightGroupGoals.length; i++) {
      const t = this.FlightGroupGoals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeSByte(hex, this.BonusGoalPoints, 0x0a6);
    offset = 0x0a8;
    for (let i = 0; i < this.Waypoints.length; i++) {
      const t = this.Waypoints[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Unknown19, 0x120);
    writeByte(hex, this.Unknown20, 0x122);
    writeBool(hex, this.Unknown21, 0x123);

    return hex;
  }

  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || 'Unknown';
  }

  public get StatusLabel(): string {
    return Constants.STATUS[this.Status] || 'Unknown';
  }

  public get WarheadLabel(): string {
    return Constants.WARHEAD[this.Warhead] || 'Unknown';
  }

  public get BeamLabel(): string {
    return Constants.BEAM[this.Beam] || 'Unknown';
  }

  public get GroupAILabel(): string {
    return Constants.GROUPAI[this.GroupAI] || 'Unknown';
  }

  public get MarkingsLabel(): string {
    return Constants.MARKINGS[this.Markings] || 'Unknown';
  }

  public get FormationLabel(): string {
    return Constants.FORMATION[this.Formation] || 'Unknown';
  }

  public get ArrivalDifficultyLabel(): string {
    return Constants.ARRIVALDIFFICULTY[this.ArrivalDifficulty] || 'Unknown';
  }

  public get AbortTriggerLabel(): string {
    return Constants.ABORTTRIGGER[this.AbortTrigger] || 'Unknown';
  }

  public getLength(): number {
    return this.FLIGHTGROUPLENGTH;
  }
}

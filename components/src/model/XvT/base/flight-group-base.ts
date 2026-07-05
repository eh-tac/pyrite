import { Byteable } from "../../../byteable";
import {
  AbortTrigger,
  ArrivalDifficulty,
  Beam,
  Constants,
  Formation,
  GroupAI,
  Markings,
  Radio,
  Ships,
  Status,
  Warhead,
} from "../constants";
import { GoalFG } from "../goal-fg";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Order } from "../order";
import { Role } from "../role";
import { Trigger } from "../trigger";
import { Waypt } from "../waypt";
import { getBool, getByte, getString, writeBool, writeByte, writeObject, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public readonly FLIGHTGROUPLENGTH: number = 1378;
  public Name: string;
  public Roles: Role[];
  public Cargo: string;
  public SpecialCargo: string;
  public SpecialCargoCraft: number;
  public RandomSpecialCargo: boolean;
  public CraftType: Ships;
  public NumberOfCraft: number;
  public Status1: Status;
  public Warhead: Warhead;
  public Beam: Beam;
  public IFF: number;
  public Team: number;
  public GroupAI: GroupAI;
  public Markings: Markings;
  public Radio: Radio;
  public Formation: Formation;
  public FormationSpacing: number;
  public GlobalGroup: number;
  public LeaderSpacing: number;
  public NumberOfWaves: number;
  public Unknown1: number;
  public Unknown2: boolean;
  public PlayerNumber: number;
  public ArriveOnlyIfHuman: number;
  public PlayerCraft: number;
  public Yaw: number;
  public Pitch: number;
  public Roll: number;
  public ArrivalDifficulty: ArrivalDifficulty;
  public Arrival1: Trigger;
  public Arrival2: Trigger;
  public Arrival1OrArrival2: boolean;
  public Arrival3: Trigger;
  public Arrival4: Trigger;
  public Arrival3OrArrival4: boolean;
  public Arrival12OrArrival34: boolean;
  public Unknown3: number;
  public ArrivalDelayMinutes: number;
  public ArrivalDelaySeconds: number;
  public Departure1: Trigger;
  public Departure2: Trigger;
  public Departure1OrDeparture2: boolean;
  public DepartureDelayMinutes: number;
  public DepartureDelaySeconds: number;
  public AbortTrigger: AbortTrigger;
  public Unknown4: number;
  public Unknown5: number;
  public ArrivalMothership: number;
  public ArriveViaMothership: number;
  public AlternateArrivalMothership: number;
  public AlternateArriveViaMothership: number;
  public DepartureMothership: number;
  public DepartViaMothership: number;
  public AlternateDepartureMothership: number;
  public AlternatDepartViaMothership: number;
  public Orders: Order[];
  public SkipToOrder4: Trigger[];
  public Skip1OrSkip2: boolean;
  public Goals: GoalFG[];
  public Waypoints: Waypt[];
  public Unknown17: boolean;
  public Unknown18: boolean;
  public Unknown19: boolean;
  public Unknown20: number;
  public Unknown21: number;
  public Countermeasures: number;
  public CraftExplosionTime: number;
  public Status2: Status;
  public GlobalUnit: number;
  public Unknown22: boolean;
  public Unknown23: boolean;
  public Unknown24: boolean;
  public Unknown25: boolean;
  public Unknown26: boolean;
  public Unknown27: boolean;
  public Unknown28: boolean;
  public Unknown29: boolean;
  public OptionalWarheads: number[];
  public OptionalBeams: number[];
  public OptionalCountermeasures: number[];
  public OptionalCraftCategory: number;
  public OptionalCraft: number[];
  public NumberOfOptionalCraft: number[];
  public NumberOfOptionalCraftWaves: number[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getString(hex, 0x000, 20);
    this.Roles = [];
    offset = 0x014;
    for (let i = 0; i < 4; i++) {
      const t = new Role(hex.slice(offset), this.TIE);
      this.Roles.push(t);
      offset += t.getLength();
    }
    this.Cargo = getString(hex, 0x028, 20);
    this.SpecialCargo = getString(hex, 0x03c, 20);
    this.SpecialCargoCraft = getByte(hex, 0x050);
    this.RandomSpecialCargo = getBool(hex, 0x051);
    this.CraftType = getByte(hex, 0x052) as Ships;
    this.NumberOfCraft = getByte(hex, 0x053);
    this.Status1 = getByte(hex, 0x054) as Status;
    this.Warhead = getByte(hex, 0x055) as Warhead;
    this.Beam = getByte(hex, 0x056) as Beam;
    this.IFF = getByte(hex, 0x057);
    this.Team = getByte(hex, 0x058);
    this.GroupAI = getByte(hex, 0x059) as GroupAI;
    this.Markings = getByte(hex, 0x05a) as Markings;
    this.Radio = getByte(hex, 0x05b) as Radio;
    this.Formation = getByte(hex, 0x05d) as Formation;
    this.FormationSpacing = getByte(hex, 0x05e);
    this.GlobalGroup = getByte(hex, 0x05f);
    this.LeaderSpacing = getByte(hex, 0x060);
    this.NumberOfWaves = getByte(hex, 0x061);
    this.Unknown1 = getByte(hex, 0x062);
    this.Unknown2 = getBool(hex, 0x063);
    this.PlayerNumber = getByte(hex, 0x064);
    this.ArriveOnlyIfHuman = getByte(hex, 0x065);
    this.PlayerCraft = getByte(hex, 0x066);
    this.Yaw = getByte(hex, 0x067);
    this.Pitch = getByte(hex, 0x068);
    this.Roll = getByte(hex, 0x069);
    this.ArrivalDifficulty = getByte(hex, 0x06d) as ArrivalDifficulty;
    this.Arrival1 = new Trigger(hex.slice(0x06e), this.TIE);
    this.Arrival2 = new Trigger(hex.slice(0x072), this.TIE);
    this.Arrival1OrArrival2 = getBool(hex, 0x078);
    this.Arrival3 = new Trigger(hex.slice(0x079), this.TIE);
    this.Arrival4 = new Trigger(hex.slice(0x07d), this.TIE);
    this.Arrival3OrArrival4 = getBool(hex, 0x083);
    this.Arrival12OrArrival34 = getBool(hex, 0x084);
    this.Unknown3 = getByte(hex, 0x085);
    this.ArrivalDelayMinutes = getByte(hex, 0x086);
    this.ArrivalDelaySeconds = getByte(hex, 0x087);
    this.Departure1 = new Trigger(hex.slice(0x088), this.TIE);
    this.Departure2 = new Trigger(hex.slice(0x08c), this.TIE);
    this.Departure1OrDeparture2 = getBool(hex, 0x092);
    this.DepartureDelayMinutes = getByte(hex, 0x093);
    this.DepartureDelaySeconds = getByte(hex, 0x094);
    this.AbortTrigger = getByte(hex, 0x095) as AbortTrigger;
    this.Unknown4 = getByte(hex, 0x096);
    this.Unknown5 = getByte(hex, 0x098);
    this.ArrivalMothership = getByte(hex, 0x09a);
    this.ArriveViaMothership = getByte(hex, 0x09b);
    this.AlternateArrivalMothership = getByte(hex, 0x09c);
    this.AlternateArriveViaMothership = getByte(hex, 0x09d);
    this.DepartureMothership = getByte(hex, 0x09e);
    this.DepartViaMothership = getByte(hex, 0x09f);
    this.AlternateDepartureMothership = getByte(hex, 0x0a0);
    this.AlternatDepartViaMothership = getByte(hex, 0x0a1);
    this.Orders = [];
    offset = 0x0a2;
    for (let i = 0; i < 4; i++) {
      const t = new Order(hex.slice(offset), this.TIE);
      this.Orders.push(t);
      offset += t.getLength();
    }
    this.SkipToOrder4 = [];
    offset = 0x1ea;
    for (let i = 0; i < 2; i++) {
      const t = new Trigger(hex.slice(offset), this.TIE);
      this.SkipToOrder4.push(t);
      offset += t.getLength();
    }
    this.Skip1OrSkip2 = getBool(hex, 0x1f4);
    this.Goals = [];
    offset = 0x1f5;
    for (let i = 0; i < 8; i++) {
      const t = new GoalFG(hex.slice(offset), this.TIE);
      this.Goals.push(t);
      offset += t.getLength();
    }
    this.Waypoints = [];
    offset = 0x466;
    for (let i = 0; i < 4; i++) {
      const t = new Waypt(hex.slice(offset), this.TIE);
      this.Waypoints.push(t);
      offset += t.getLength();
    }
    this.Unknown17 = getBool(hex, 0x516);
    this.Unknown18 = getBool(hex, 0x518);
    this.Unknown19 = getBool(hex, 0x520);
    this.Unknown20 = getByte(hex, 0x521);
    this.Unknown21 = getByte(hex, 0x522);
    this.Countermeasures = getByte(hex, 0x523);
    this.CraftExplosionTime = getByte(hex, 0x524);
    this.Status2 = getByte(hex, 0x525) as Status;
    this.GlobalUnit = getByte(hex, 0x526);
    this.Unknown22 = getBool(hex, 0x527);
    this.Unknown23 = getBool(hex, 0x528);
    this.Unknown24 = getBool(hex, 0x529);
    this.Unknown25 = getBool(hex, 0x52a);
    this.Unknown26 = getBool(hex, 0x52b);
    this.Unknown27 = getBool(hex, 0x52c);
    this.Unknown28 = getBool(hex, 0x52d);
    this.Unknown29 = getBool(hex, 0x52e);
    this.OptionalWarheads = [];
    offset = 0x530;
    for (let i = 0; i < 8; i++) {
      const t = getByte(hex, offset);
      this.OptionalWarheads.push(t);
      offset += 1;
    }
    this.OptionalBeams = [];
    offset = 0x538;
    for (let i = 0; i < 4; i++) {
      const t = getByte(hex, offset);
      this.OptionalBeams.push(t);
      offset += 1;
    }
    this.OptionalCountermeasures = [];
    offset = 0x53e;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.OptionalCountermeasures.push(t);
      offset += 1;
    }
    this.OptionalCraftCategory = getByte(hex, 0x542);
    this.OptionalCraft = [];
    offset = 0x543;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.OptionalCraft.push(t);
      offset += 1;
    }
    this.NumberOfOptionalCraft = [];
    offset = 0x54d;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.NumberOfOptionalCraft.push(t);
      offset += 1;
    }
    this.NumberOfOptionalCraftWaves = [];
    offset = 0x557;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.NumberOfOptionalCraftWaves.push(t);
      offset += 1;
    }
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Name: this.Name,
      Roles: this.Roles.map((t) => t.toJSON()),
      Cargo: this.Cargo,
      SpecialCargo: this.SpecialCargo,
      SpecialCargoCraft: this.SpecialCargoCraft,
      RandomSpecialCargo: this.RandomSpecialCargo,
      CraftType: this.CraftTypeLabel,
      NumberOfCraft: this.NumberOfCraft,
      Status1: this.Status1Label,
      Warhead: this.WarheadLabel,
      Beam: this.BeamLabel,
      IFF: this.IFF,
      Team: this.Team,
      GroupAI: this.GroupAILabel,
      Markings: this.MarkingsLabel,
      Radio: this.RadioLabel,
      Formation: this.FormationLabel,
      FormationSpacing: this.FormationSpacing,
      GlobalGroup: this.GlobalGroup,
      LeaderSpacing: this.LeaderSpacing,
      NumberOfWaves: this.NumberOfWaves,
      Unknown1: this.Unknown1,
      Unknown2: this.Unknown2,
      PlayerNumber: this.PlayerNumber,
      ArriveOnlyIfHuman: this.ArriveOnlyIfHuman,
      PlayerCraft: this.PlayerCraft,
      Yaw: this.Yaw,
      Pitch: this.Pitch,
      Roll: this.Roll,
      ArrivalDifficulty: this.ArrivalDifficultyLabel,
      Arrival1: this.Arrival1.toJSON(),
      Arrival2: this.Arrival2.toJSON(),
      Arrival1OrArrival2: this.Arrival1OrArrival2,
      Arrival3: this.Arrival3.toJSON(),
      Arrival4: this.Arrival4.toJSON(),
      Arrival3OrArrival4: this.Arrival3OrArrival4,
      Arrival12OrArrival34: this.Arrival12OrArrival34,
      Unknown3: this.Unknown3,
      ArrivalDelayMinutes: this.ArrivalDelayMinutes,
      ArrivalDelaySeconds: this.ArrivalDelaySeconds,
      Departure1: this.Departure1.toJSON(),
      Departure2: this.Departure2.toJSON(),
      Departure1OrDeparture2: this.Departure1OrDeparture2,
      DepartureDelayMinutes: this.DepartureDelayMinutes,
      DepartureDelaySeconds: this.DepartureDelaySeconds,
      AbortTrigger: this.AbortTriggerLabel,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5,
      ArrivalMothership: this.ArrivalMothership,
      ArriveViaMothership: this.ArriveViaMothership,
      AlternateArrivalMothership: this.AlternateArrivalMothership,
      AlternateArriveViaMothership: this.AlternateArriveViaMothership,
      DepartureMothership: this.DepartureMothership,
      DepartViaMothership: this.DepartViaMothership,
      AlternateDepartureMothership: this.AlternateDepartureMothership,
      AlternatDepartViaMothership: this.AlternatDepartViaMothership,
      Orders: this.Orders.map((t) => t.toJSON()),
      SkipToOrder4: this.SkipToOrder4.map((t) => t.toJSON()),
      Skip1OrSkip2: this.Skip1OrSkip2,
      Goals: this.Goals.map((t) => t.toJSON()),
      Waypoints: this.Waypoints.map((t) => t.toJSON()),
      Unknown17: this.Unknown17,
      Unknown18: this.Unknown18,
      Unknown19: this.Unknown19,
      Unknown20: this.Unknown20,
      Unknown21: this.Unknown21,
      Countermeasures: this.Countermeasures,
      CraftExplosionTime: this.CraftExplosionTime,
      Status2: this.Status2Label,
      GlobalUnit: this.GlobalUnit,
      Unknown22: this.Unknown22,
      Unknown23: this.Unknown23,
      Unknown24: this.Unknown24,
      Unknown25: this.Unknown25,
      Unknown26: this.Unknown26,
      Unknown27: this.Unknown27,
      Unknown28: this.Unknown28,
      Unknown29: this.Unknown29,
      OptionalWarheads: this.OptionalWarheads,
      OptionalBeams: this.OptionalBeams,
      OptionalCountermeasures: this.OptionalCountermeasures,
      OptionalCraftCategory: this.OptionalCraftCategory,
      OptionalCraft: this.OptionalCraft,
      NumberOfOptionalCraft: this.NumberOfOptionalCraft,
      NumberOfOptionalCraftWaves: this.NumberOfOptionalCraftWaves,
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeString(hex, this.Name, 0x000, 20);
    offset = 0x014;
    for (let i = 0; i < this.Roles.length; i++) {
      const t = this.Roles[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeString(hex, this.Cargo, 0x028, 20);
    writeString(hex, this.SpecialCargo, 0x03c, 20);
    writeByte(hex, this.SpecialCargoCraft, 0x050);
    writeBool(hex, this.RandomSpecialCargo, 0x051);
    writeByte(hex, this.CraftType, 0x052);
    writeByte(hex, this.NumberOfCraft, 0x053);
    writeByte(hex, this.Status1, 0x054);
    writeByte(hex, this.Warhead, 0x055);
    writeByte(hex, this.Beam, 0x056);
    writeByte(hex, this.IFF, 0x057);
    writeByte(hex, this.Team, 0x058);
    writeByte(hex, this.GroupAI, 0x059);
    writeByte(hex, this.Markings, 0x05a);
    writeByte(hex, this.Radio, 0x05b);
    writeByte(hex, this.Formation, 0x05d);
    writeByte(hex, this.FormationSpacing, 0x05e);
    writeByte(hex, this.GlobalGroup, 0x05f);
    writeByte(hex, this.LeaderSpacing, 0x060);
    writeByte(hex, this.NumberOfWaves, 0x061);
    writeByte(hex, this.Unknown1, 0x062);
    writeBool(hex, this.Unknown2, 0x063);
    writeByte(hex, this.PlayerNumber, 0x064);
    writeByte(hex, this.ArriveOnlyIfHuman, 0x065);
    writeByte(hex, this.PlayerCraft, 0x066);
    writeByte(hex, this.Yaw, 0x067);
    writeByte(hex, this.Pitch, 0x068);
    writeByte(hex, this.Roll, 0x069);
    writeByte(hex, this.ArrivalDifficulty, 0x06d);
    writeObject(hex, this.Arrival1, 0x06e);
    writeObject(hex, this.Arrival2, 0x072);
    writeBool(hex, this.Arrival1OrArrival2, 0x078);
    writeObject(hex, this.Arrival3, 0x079);
    writeObject(hex, this.Arrival4, 0x07d);
    writeBool(hex, this.Arrival3OrArrival4, 0x083);
    writeBool(hex, this.Arrival12OrArrival34, 0x084);
    writeByte(hex, this.Unknown3, 0x085);
    writeByte(hex, this.ArrivalDelayMinutes, 0x086);
    writeByte(hex, this.ArrivalDelaySeconds, 0x087);
    writeObject(hex, this.Departure1, 0x088);
    writeObject(hex, this.Departure2, 0x08c);
    writeBool(hex, this.Departure1OrDeparture2, 0x092);
    writeByte(hex, this.DepartureDelayMinutes, 0x093);
    writeByte(hex, this.DepartureDelaySeconds, 0x094);
    writeByte(hex, this.AbortTrigger, 0x095);
    writeByte(hex, this.Unknown4, 0x096);
    writeByte(hex, this.Unknown5, 0x098);
    writeByte(hex, this.ArrivalMothership, 0x09a);
    writeByte(hex, this.ArriveViaMothership, 0x09b);
    writeByte(hex, this.AlternateArrivalMothership, 0x09c);
    writeByte(hex, this.AlternateArriveViaMothership, 0x09d);
    writeByte(hex, this.DepartureMothership, 0x09e);
    writeByte(hex, this.DepartViaMothership, 0x09f);
    writeByte(hex, this.AlternateDepartureMothership, 0x0a0);
    writeByte(hex, this.AlternatDepartViaMothership, 0x0a1);
    offset = 0x0a2;
    for (let i = 0; i < this.Orders.length; i++) {
      const t = this.Orders[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x1ea;
    for (let i = 0; i < this.SkipToOrder4.length; i++) {
      const t = this.SkipToOrder4[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Skip1OrSkip2, 0x1f4);
    offset = 0x1f5;
    for (let i = 0; i < this.Goals.length; i++) {
      const t = this.Goals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x466;
    for (let i = 0; i < this.Waypoints.length; i++) {
      const t = this.Waypoints[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Unknown17, 0x516);
    writeBool(hex, this.Unknown18, 0x518);
    writeBool(hex, this.Unknown19, 0x520);
    writeByte(hex, this.Unknown20, 0x521);
    writeByte(hex, this.Unknown21, 0x522);
    writeByte(hex, this.Countermeasures, 0x523);
    writeByte(hex, this.CraftExplosionTime, 0x524);
    writeByte(hex, this.Status2, 0x525);
    writeByte(hex, this.GlobalUnit, 0x526);
    writeBool(hex, this.Unknown22, 0x527);
    writeBool(hex, this.Unknown23, 0x528);
    writeBool(hex, this.Unknown24, 0x529);
    writeBool(hex, this.Unknown25, 0x52a);
    writeBool(hex, this.Unknown26, 0x52b);
    writeBool(hex, this.Unknown27, 0x52c);
    writeBool(hex, this.Unknown28, 0x52d);
    writeBool(hex, this.Unknown29, 0x52e);
    offset = 0x530;
    for (let i = 0; i < this.OptionalWarheads.length; i++) {
      const t = this.OptionalWarheads[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x538;
    for (let i = 0; i < this.OptionalBeams.length; i++) {
      const t = this.OptionalBeams[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x53e;
    for (let i = 0; i < this.OptionalCountermeasures.length; i++) {
      const t = this.OptionalCountermeasures[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.OptionalCraftCategory, 0x542);
    offset = 0x543;
    for (let i = 0; i < this.OptionalCraft.length; i++) {
      const t = this.OptionalCraft[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x54d;
    for (let i = 0; i < this.NumberOfOptionalCraft.length; i++) {
      const t = this.NumberOfOptionalCraft[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x557;
    for (let i = 0; i < this.NumberOfOptionalCraftWaves.length; i++) {
      const t = this.NumberOfOptionalCraftWaves[i];
      writeByte(hex, t, offset);
      offset += 1;
    }

    return hex;
  }

  public get CraftTypeLabel(): string {
    return Constants.SHIPS[this.CraftType] || "Unknown";
  }

  public get Status1Label(): string {
    return Constants.STATUS[this.Status1] || "Unknown";
  }

  public get WarheadLabel(): string {
    return Constants.WARHEAD[this.Warhead] || "Unknown";
  }

  public get BeamLabel(): string {
    return Constants.BEAM[this.Beam] || "Unknown";
  }

  public get GroupAILabel(): string {
    return Constants.GROUPAI[this.GroupAI] || "Unknown";
  }

  public get MarkingsLabel(): string {
    return Constants.MARKINGS[this.Markings] || "Unknown";
  }

  public get RadioLabel(): string {
    return Constants.RADIO[this.Radio] || "Unknown";
  }

  public get FormationLabel(): string {
    return Constants.FORMATION[this.Formation] || "Unknown";
  }

  public get ArrivalDifficultyLabel(): string {
    return Constants.ARRIVALDIFFICULTY[this.ArrivalDifficulty] || "Unknown";
  }

  public get AbortTriggerLabel(): string {
    return Constants.ABORTTRIGGER[this.AbortTrigger] || "Unknown";
  }

  public get Status2Label(): string {
    return Constants.STATUS[this.Status2] || "Unknown";
  }

  public getLength(): number {
    return this.FLIGHTGROUPLENGTH;
  }
}

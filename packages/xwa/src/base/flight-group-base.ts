import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import {
  AbortTrigger,
  ArrivalDifficulty,
  Beam,
  Constants,
  CraftType,
  Designation,
  Formation,
  FormationSpacing,
  GroupAI,
  Markings,
  Radio,
  Status,
  StopArrivingWhen,
  Warhead
} from '../constants';
import { GoalFG } from '../goal-fg';
import { Order } from '../order';
import { TriggerPair } from '../trigger-pair';
import { Waypt } from '../waypt';
import {
  getBool,
  getByte,
  getInt,
  getString,
  writeBool,
  writeByte,
  writeInt,
  writeObject,
  writeString
} from '@pyrite/core';
export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public readonly FLIGHTGROUPLENGTH: number = 3646;
  public Name: string;
  public EnableDesignation: number;
  public EnableDesignation2: number;
  public Designation1: Designation;
  public Designation2: Designation;
  public Comm: number; //(was Unknown1) {None, Minimal, Normal, Verbose}
  public GlobalCargoIndex: number;
  public GlobalSpecialCargoIndex: number;
  public Cargo: string;
  public SpecialCargo: string;
  public CraftRole: string;
  public SpecialCargoCraft: number;
  public RandomSpecialCargoCraft: boolean;
  public CraftType: CraftType;
  public NumberOfCraft: number;
  public Status1: Status;
  public Warhead: Warhead;
  public Beam: Beam;
  public Iff: number;
  public Team: number;
  public GroupAI: GroupAI;
  public Markings: Markings;
  public Radio: Radio;
  public Formation: Formation;
  public FormationSpacing: FormationSpacing;
  public GlobalGroup: number;
  public LeaderSpacingUnused: number;
  public NumberOfWaves: number;
  public WavesDelay: number;
  public StopArrivingWhen: StopArrivingWhen;
  public PlayerNumber: number;
  public ArriveOnlyIfHuman: boolean;
  public PlayerCraft: number;
  public Yaw: number;
  public Pitch: number;
  public Roll: number;
  public Unknown4: number;
  public Unknown5: number;
  public ArrivalDifficulty: ArrivalDifficulty;
  public Arrival: TriggerPair[];
  public Arrivals12OrArrivals34: boolean;
  public ArrivalDelayMinutes: number;
  public ArrivalDelaySeconds: number;
  public Departure: TriggerPair;
  public DepartureDelayMinutes: number;
  public DepartureDelaySeconds: number;
  public AbortTrigger: AbortTrigger;
  public ArrivalRandDelaySeconds: number;
  public Unknown8: number;
  public ArrivalMothership: number;
  public ArrivalMethod: number; //{Hyper, Mothership, Hyp Rgn FG}
  public DepartureMothership: number;
  public DepartMethod: boolean; //{Hyper, Mothership, Planet}
  public AlternateMothership: number;
  public AlternateMothershipUsed: boolean;
  public CapturedDepartureMothership: number;
  public CapturedDepartViaMothership: boolean;
  public Orders: Order[];
  public SkipTriggers: TriggerPair[];
  public FGGoals: GoalFG[];
  public StartPoints: Waypt[];
  public CaptureHyperPoint: Waypt;
  public HyperPoint: Waypt;
  public StartPointRegions: number[];
  public CaptureHyperRegion: number;
  public HyperPointRegion: number;
  public DisableWaveNumbering: boolean;
  public DepartureClockMin: number; //(was Unknown32)
  public DepartureClockSec: number; //(was Unknown33)
  public Countermeasures: number;
  public CraftExplosionTime: number;
  public Status2: number;
  public GlobalUnit: number;
  public Handicap: number; //{None, FavorRebels, EvenOnly, FavorImps, FavorRebsEven, FavorImpsEven}
  public OptionalWarheads: number[];
  public OptionalBeams: number[];
  public OptionalCountermeasures: number[];
  public OptionalCraftCategory: number;
  public OptionalCraft: number[];
  public NumberOfOptionalCraft: number[];
  public NumberofOptionalCraftWaves: number[];
  public PilotID: string;
  public Backdrop: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getString(hex, 0x000, 20);
    this.EnableDesignation = getByte(hex, 0x014);
    this.EnableDesignation2 = getByte(hex, 0x015);
    this.Designation1 = getByte(hex, 0x016) as Designation;
    this.Designation2 = getByte(hex, 0x017) as Designation;
    this.Comm = getByte(hex, 0x018);
    this.GlobalCargoIndex = getByte(hex, 0x019);
    this.GlobalSpecialCargoIndex = getByte(hex, 0x01a);
    this.Cargo = getString(hex, 0x028, 20);
    this.SpecialCargo = getString(hex, 0x03c, 20);
    this.CraftRole = getString(hex, 0x050, 20);
    this.SpecialCargoCraft = getByte(hex, 0x069);
    this.RandomSpecialCargoCraft = getBool(hex, 0x06a);
    this.CraftType = getByte(hex, 0x06b) as CraftType;
    this.NumberOfCraft = getByte(hex, 0x06c);
    this.Status1 = getByte(hex, 0x06d) as Status;
    this.Warhead = getByte(hex, 0x06e) as Warhead;
    this.Beam = getByte(hex, 0x06f) as Beam;
    this.Iff = getByte(hex, 0x070);
    this.Team = getByte(hex, 0x071);
    this.GroupAI = getByte(hex, 0x072) as GroupAI;
    this.Markings = getByte(hex, 0x073) as Markings;
    this.Radio = getByte(hex, 0x074) as Radio;
    this.Formation = getByte(hex, 0x076) as Formation;
    this.FormationSpacing = getByte(hex, 0x077) as FormationSpacing;
    this.GlobalGroup = getByte(hex, 0x078);
    this.LeaderSpacingUnused = getByte(hex, 0x079);
    this.NumberOfWaves = getByte(hex, 0x07a);
    this.WavesDelay = getByte(hex, 0x07b);
    this.StopArrivingWhen = getByte(hex, 0x07c) as StopArrivingWhen;
    this.PlayerNumber = getByte(hex, 0x07d);
    this.ArriveOnlyIfHuman = getBool(hex, 0x07e);
    this.PlayerCraft = getByte(hex, 0x07f);
    this.Yaw = getByte(hex, 0x080);
    this.Pitch = getByte(hex, 0x081);
    this.Roll = getByte(hex, 0x082);
    this.Unknown4 = getByte(hex, 0x084);
    this.Unknown5 = getByte(hex, 0x086);
    this.ArrivalDifficulty = getByte(hex, 0x087) as ArrivalDifficulty;
    this.Arrival = [];
    offset = 0x088;
    for (let i = 0; i < 2; i++) {
      const t = new TriggerPair(hex.slice(offset), this.TIE);
      this.Arrival.push(t);
      offset += t.getLength();
    }
    this.Arrivals12OrArrivals34 = getBool(hex, 0x0a8);
    this.ArrivalDelayMinutes = getByte(hex, 0x0aa);
    this.ArrivalDelaySeconds = getByte(hex, 0x0ab);
    this.Departure = new TriggerPair(hex.slice(0x0ac), this.TIE);
    this.DepartureDelayMinutes = getByte(hex, 0x0bc);
    this.DepartureDelaySeconds = getByte(hex, 0x0bd);
    this.AbortTrigger = getByte(hex, 0x0be) as AbortTrigger;
    this.ArrivalRandDelaySeconds = getByte(hex, 0x0bf);
    this.Unknown8 = getByte(hex, 0x0c0);
    this.ArrivalMothership = getByte(hex, 0x0c2);
    this.ArrivalMethod = getByte(hex, 0x0c3);
    this.DepartureMothership = getByte(hex, 0x0c4);
    this.DepartMethod = getBool(hex, 0x0c5);
    this.AlternateMothership = getByte(hex, 0x0c6);
    this.AlternateMothershipUsed = getBool(hex, 0x0c7);
    this.CapturedDepartureMothership = getByte(hex, 0x0c8);
    this.CapturedDepartViaMothership = getBool(hex, 0x0c9);
    this.Orders = [];
    offset = 0x0ca;
    for (let i = 0; i < 16; i++) {
      const t = new Order(hex.slice(offset), this.TIE);
      this.Orders.push(t);
      offset += t.getLength();
    }
    this.SkipTriggers = [];
    offset = 0xa0a;
    for (let i = 0; i < 16; i++) {
      const t = new TriggerPair(hex.slice(offset), this.TIE);
      this.SkipTriggers.push(t);
      offset += t.getLength();
    }
    this.FGGoals = [];
    offset = 0xb0a;
    for (let i = 0; i < 8; i++) {
      const t = new GoalFG(hex.slice(offset), this.TIE);
      this.FGGoals.push(t);
      offset += t.getLength();
    }
    this.StartPoints = [];
    offset = 0xd8a;
    for (let i = 0; i < 2; i++) {
      const t = new Waypt(hex.slice(offset), this.TIE);
      this.StartPoints.push(t);
      offset += t.getLength();
    }
    this.CaptureHyperPoint = new Waypt(hex.slice(0xd9a), this.TIE);
    this.HyperPoint = new Waypt(hex.slice(0xda2), this.TIE);
    this.StartPointRegions = [];
    offset = 0xdaa;
    for (let i = 0; i < 2; i++) {
      const t = getByte(hex, offset);
      this.StartPointRegions.push(t);
      offset += 1;
    }
    this.CaptureHyperRegion = getByte(hex, 0xdac);
    this.HyperPointRegion = getByte(hex, 0xdad);
    this.DisableWaveNumbering = getBool(hex, 0xdc4);
    this.DepartureClockMin = getByte(hex, 0xdc5);
    this.DepartureClockSec = getByte(hex, 0xdc6);
    this.Countermeasures = getByte(hex, 0xdc7);
    this.CraftExplosionTime = getByte(hex, 0xdc8);
    this.Status2 = getByte(hex, 0xdc9);
    this.GlobalUnit = getByte(hex, 0xdca);
    this.Handicap = getByte(hex, 0xdcb);
    this.OptionalWarheads = [];
    offset = 0xdcc;
    for (let i = 0; i < 8; i++) {
      const t = getByte(hex, offset);
      this.OptionalWarheads.push(t);
      offset += 1;
    }
    this.OptionalBeams = [];
    offset = 0xdd4;
    for (let i = 0; i < 4; i++) {
      const t = getByte(hex, offset);
      this.OptionalBeams.push(t);
      offset += 1;
    }
    this.OptionalCountermeasures = [];
    offset = 0xdda;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.OptionalCountermeasures.push(t);
      offset += 1;
    }
    this.OptionalCraftCategory = getByte(hex, 0xdde);
    this.OptionalCraft = [];
    offset = 0xddf;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.OptionalCraft.push(t);
      offset += 1;
    }
    this.NumberOfOptionalCraft = [];
    offset = 0xde9;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.NumberOfOptionalCraft.push(t);
      offset += 1;
    }
    this.NumberofOptionalCraftWaves = [];
    offset = 0xdf3;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.NumberofOptionalCraftWaves.push(t);
      offset += 1;
    }
    this.PilotID = getString(hex, 0xdfd, 20);
    this.Backdrop = getInt(hex, 0xe12);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Name: this.Name,
      EnableDesignation: this.EnableDesignation,
      EnableDesignation2: this.EnableDesignation2,
      Designation1: this.Designation1Label,
      Designation2: this.Designation2Label,
      Comm: this.Comm,
      GlobalCargoIndex: this.GlobalCargoIndex,
      GlobalSpecialCargoIndex: this.GlobalSpecialCargoIndex,
      Cargo: this.Cargo,
      SpecialCargo: this.SpecialCargo,
      CraftRole: this.CraftRole,
      SpecialCargoCraft: this.SpecialCargoCraft,
      RandomSpecialCargoCraft: this.RandomSpecialCargoCraft,
      CraftType: this.CraftTypeLabel,
      NumberOfCraft: this.NumberOfCraft,
      Status1: this.Status1Label,
      Warhead: this.WarheadLabel,
      Beam: this.BeamLabel,
      Iff: this.Iff,
      Team: this.Team,
      GroupAI: this.GroupAILabel,
      Markings: this.MarkingsLabel,
      Radio: this.RadioLabel,
      Formation: this.FormationLabel,
      FormationSpacing: this.FormationSpacingLabel,
      GlobalGroup: this.GlobalGroup,
      LeaderSpacingUnused: this.LeaderSpacingUnused,
      NumberOfWaves: this.NumberOfWaves,
      WavesDelay: this.WavesDelay,
      StopArrivingWhen: this.StopArrivingWhenLabel,
      PlayerNumber: this.PlayerNumber,
      ArriveOnlyIfHuman: this.ArriveOnlyIfHuman,
      PlayerCraft: this.PlayerCraft,
      Yaw: this.Yaw,
      Pitch: this.Pitch,
      Roll: this.Roll,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5,
      ArrivalDifficulty: this.ArrivalDifficultyLabel,
      Arrival: this.Arrival.map((t) => t.toJSON()),
      Arrivals12OrArrivals34: this.Arrivals12OrArrivals34,
      ArrivalDelayMinutes: this.ArrivalDelayMinutes,
      ArrivalDelaySeconds: this.ArrivalDelaySeconds,
      Departure: this.Departure.toJSON(),
      DepartureDelayMinutes: this.DepartureDelayMinutes,
      DepartureDelaySeconds: this.DepartureDelaySeconds,
      AbortTrigger: this.AbortTriggerLabel,
      ArrivalRandDelaySeconds: this.ArrivalRandDelaySeconds,
      Unknown8: this.Unknown8,
      ArrivalMothership: this.ArrivalMothership,
      ArrivalMethod: this.ArrivalMethod,
      DepartureMothership: this.DepartureMothership,
      DepartMethod: this.DepartMethod,
      AlternateMothership: this.AlternateMothership,
      AlternateMothershipUsed: this.AlternateMothershipUsed,
      CapturedDepartureMothership: this.CapturedDepartureMothership,
      CapturedDepartViaMothership: this.CapturedDepartViaMothership,
      Orders: this.Orders.map((t) => t.toJSON()),
      SkipTriggers: this.SkipTriggers.map((t) => t.toJSON()),
      FGGoals: this.FGGoals.map((t) => t.toJSON()),
      StartPoints: this.StartPoints.map((t) => t.toJSON()),
      CaptureHyperPoint: this.CaptureHyperPoint.toJSON(),
      HyperPoint: this.HyperPoint.toJSON(),
      StartPointRegions: this.StartPointRegions,
      CaptureHyperRegion: this.CaptureHyperRegion,
      HyperPointRegion: this.HyperPointRegion,
      DisableWaveNumbering: this.DisableWaveNumbering,
      DepartureClockMin: this.DepartureClockMin,
      DepartureClockSec: this.DepartureClockSec,
      Countermeasures: this.Countermeasures,
      CraftExplosionTime: this.CraftExplosionTime,
      Status2: this.Status2,
      GlobalUnit: this.GlobalUnit,
      Handicap: this.Handicap,
      OptionalWarheads: this.OptionalWarheads,
      OptionalBeams: this.OptionalBeams,
      OptionalCountermeasures: this.OptionalCountermeasures,
      OptionalCraftCategory: this.OptionalCraftCategory,
      OptionalCraft: this.OptionalCraft,
      NumberOfOptionalCraft: this.NumberOfOptionalCraft,
      NumberofOptionalCraftWaves: this.NumberofOptionalCraftWaves,
      PilotID: this.PilotID,
      Backdrop: this.Backdrop
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeString(hex, this.Name, 0x000, 20);
    writeByte(hex, this.EnableDesignation, 0x014);
    writeByte(hex, this.EnableDesignation2, 0x015);
    writeByte(hex, this.Designation1, 0x016);
    writeByte(hex, this.Designation2, 0x017);
    writeByte(hex, this.Comm, 0x018);
    writeByte(hex, this.GlobalCargoIndex, 0x019);
    writeByte(hex, this.GlobalSpecialCargoIndex, 0x01a);
    writeString(hex, this.Cargo, 0x028, 20);
    writeString(hex, this.SpecialCargo, 0x03c, 20);
    writeString(hex, this.CraftRole, 0x050, 20);
    writeByte(hex, this.SpecialCargoCraft, 0x069);
    writeBool(hex, this.RandomSpecialCargoCraft, 0x06a);
    writeByte(hex, this.CraftType, 0x06b);
    writeByte(hex, this.NumberOfCraft, 0x06c);
    writeByte(hex, this.Status1, 0x06d);
    writeByte(hex, this.Warhead, 0x06e);
    writeByte(hex, this.Beam, 0x06f);
    writeByte(hex, this.Iff, 0x070);
    writeByte(hex, this.Team, 0x071);
    writeByte(hex, this.GroupAI, 0x072);
    writeByte(hex, this.Markings, 0x073);
    writeByte(hex, this.Radio, 0x074);
    writeByte(hex, this.Formation, 0x076);
    writeByte(hex, this.FormationSpacing, 0x077);
    writeByte(hex, this.GlobalGroup, 0x078);
    writeByte(hex, this.LeaderSpacingUnused, 0x079);
    writeByte(hex, this.NumberOfWaves, 0x07a);
    writeByte(hex, this.WavesDelay, 0x07b);
    writeByte(hex, this.StopArrivingWhen, 0x07c);
    writeByte(hex, this.PlayerNumber, 0x07d);
    writeBool(hex, this.ArriveOnlyIfHuman, 0x07e);
    writeByte(hex, this.PlayerCraft, 0x07f);
    writeByte(hex, this.Yaw, 0x080);
    writeByte(hex, this.Pitch, 0x081);
    writeByte(hex, this.Roll, 0x082);
    writeByte(hex, this.Unknown4, 0x084);
    writeByte(hex, this.Unknown5, 0x086);
    writeByte(hex, this.ArrivalDifficulty, 0x087);
    offset = 0x088;
    for (let i = 0; i < this.Arrival.length; i++) {
      const t = this.Arrival[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Arrivals12OrArrivals34, 0x0a8);
    writeByte(hex, this.ArrivalDelayMinutes, 0x0aa);
    writeByte(hex, this.ArrivalDelaySeconds, 0x0ab);
    writeObject(hex, this.Departure, 0x0ac);
    writeByte(hex, this.DepartureDelayMinutes, 0x0bc);
    writeByte(hex, this.DepartureDelaySeconds, 0x0bd);
    writeByte(hex, this.AbortTrigger, 0x0be);
    writeByte(hex, this.ArrivalRandDelaySeconds, 0x0bf);
    writeByte(hex, this.Unknown8, 0x0c0);
    writeByte(hex, this.ArrivalMothership, 0x0c2);
    writeByte(hex, this.ArrivalMethod, 0x0c3);
    writeByte(hex, this.DepartureMothership, 0x0c4);
    writeBool(hex, this.DepartMethod, 0x0c5);
    writeByte(hex, this.AlternateMothership, 0x0c6);
    writeBool(hex, this.AlternateMothershipUsed, 0x0c7);
    writeByte(hex, this.CapturedDepartureMothership, 0x0c8);
    writeBool(hex, this.CapturedDepartViaMothership, 0x0c9);
    offset = 0x0ca;
    for (let i = 0; i < this.Orders.length; i++) {
      const t = this.Orders[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xa0a;
    for (let i = 0; i < this.SkipTriggers.length; i++) {
      const t = this.SkipTriggers[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xb0a;
    for (let i = 0; i < this.FGGoals.length; i++) {
      const t = this.FGGoals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xd8a;
    for (let i = 0; i < this.StartPoints.length; i++) {
      const t = this.StartPoints[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeObject(hex, this.CaptureHyperPoint, 0xd9a);
    writeObject(hex, this.HyperPoint, 0xda2);
    offset = 0xdaa;
    for (let i = 0; i < this.StartPointRegions.length; i++) {
      const t = this.StartPointRegions[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.CaptureHyperRegion, 0xdac);
    writeByte(hex, this.HyperPointRegion, 0xdad);
    writeBool(hex, this.DisableWaveNumbering, 0xdc4);
    writeByte(hex, this.DepartureClockMin, 0xdc5);
    writeByte(hex, this.DepartureClockSec, 0xdc6);
    writeByte(hex, this.Countermeasures, 0xdc7);
    writeByte(hex, this.CraftExplosionTime, 0xdc8);
    writeByte(hex, this.Status2, 0xdc9);
    writeByte(hex, this.GlobalUnit, 0xdca);
    writeByte(hex, this.Handicap, 0xdcb);
    offset = 0xdcc;
    for (let i = 0; i < this.OptionalWarheads.length; i++) {
      const t = this.OptionalWarheads[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xdd4;
    for (let i = 0; i < this.OptionalBeams.length; i++) {
      const t = this.OptionalBeams[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xdda;
    for (let i = 0; i < this.OptionalCountermeasures.length; i++) {
      const t = this.OptionalCountermeasures[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.OptionalCraftCategory, 0xdde);
    offset = 0xddf;
    for (let i = 0; i < this.OptionalCraft.length; i++) {
      const t = this.OptionalCraft[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xde9;
    for (let i = 0; i < this.NumberOfOptionalCraft.length; i++) {
      const t = this.NumberOfOptionalCraft[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xdf3;
    for (let i = 0; i < this.NumberofOptionalCraftWaves.length; i++) {
      const t = this.NumberofOptionalCraftWaves[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeString(hex, this.PilotID, 0xdfd, 20);
    writeInt(hex, this.Backdrop, 0xe12);

    return hex;
  }

  public get Designation1Label(): string {
    return Constants.DESIGNATION[this.Designation1] || 'Unknown';
  }

  public get Designation2Label(): string {
    return Constants.DESIGNATION[this.Designation2] || 'Unknown';
  }

  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || 'Unknown';
  }

  public get Status1Label(): string {
    return Constants.STATUS[this.Status1] || 'Unknown';
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

  public get RadioLabel(): string {
    return Constants.RADIO[this.Radio] || 'Unknown';
  }

  public get FormationLabel(): string {
    return Constants.FORMATION[this.Formation] || 'Unknown';
  }

  public get FormationSpacingLabel(): string {
    return Constants.FORMATIONSPACING[this.FormationSpacing] || 'Unknown';
  }

  public get StopArrivingWhenLabel(): string {
    return Constants.STOPARRIVINGWHEN[this.StopArrivingWhen] || 'Unknown';
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

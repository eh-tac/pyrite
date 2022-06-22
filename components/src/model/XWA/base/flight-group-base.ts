import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { GoalFG } from "../goal-fg";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Order } from "../order";
import { Skip } from "../skip";
import { Trigger } from "../trigger";
import { Waypt } from "../waypt";
import { getBool, getByte, getString, writeBool, writeByte, writeObject, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public readonly FLIGHTGROUPLENGTH: number = 3646;
  public Name: string;
  public EnableDesignation: number;
  public EnableDesignation2: number;
  public Designation1: number;
  public Designation2: number;
  public Unknown1: number;
  public GlobalCargoIndex: number;
  public GlobalSpecialCargoIndex: number;
  public Cargo: string;
  public SpecialCargo: string;
  public CraftRole: string;
  public SpecialCargoCraft: number;
  public RandomSpecialCargoCraft: boolean;
  public CraftType: number;
  public NumberOfCraft: number;
  public Status1: number;
  public Warhead: number;
  public Beam: number;
  public Iff: number;
  public Team: number;
  public GroupAI: number;
  public Markings: number;
  public Radio: number;
  public Formation: number;
  public FormationSpacing: number;
  public GlobalGroup: number;
  public LeaderSpacing: number;
  public NumberOfWaves: number;
  public Unknown3: number;
  public PlayerNumber: number;
  public ArriveOnlyIfHuman: boolean;
  public PlayerCraft: number;
  public Yaw: number;
  public Pitch: number;
  public Roll: number;
  public Unknown4: number;
  public Unknown5: number;
  public ArrivalDifficulty: number;
  public Arrival1: Trigger;
  public Arrival2: Trigger;
  public Arrival1OrArrival2: boolean;
  public Unknown6: boolean;
  public Arrival3: Trigger;
  public Arrival4: Trigger;
  public Arrival3OrArrival4: boolean;
  public Arrivals12OrArrivals34: boolean;
  public ArrivalDelayMinutes: number;
  public ArrivalDelaySeconds: number;
  public Departure1: Trigger;
  public Departure2: Trigger;
  public Departure1OrDeparture2: boolean;
  public DepartureDelayMinutes: number;
  public DepartureDelaySeconds: number;
  public AbortTrigger: number;
  public Unknown7: number;
  public Unknown8: number;
  public ArrivalMothership: number;
  public ArriveViaMothership: boolean;
  public DepartureMothership: number;
  public DepartViaMothership: boolean;
  public AlternateArrivalMothership: number;
  public AlternateArriveViaMothership: boolean;
  public AlternateDepartureMothership: number;
  public AlternateDepartViaMothership: boolean;
  public Orders: Order[];
  public Skips: Skip[];
  public Goals: GoalFG[];
  public StartPoints: Waypt[];
  public HyperPoint: Waypt;
  public StartPointRegions: number[];
  public HyperPointRegion: number;
  public Unknown16: number;
  public Unknown17: number;
  public Unknown18: number;
  public Unknown19: number;
  public Unknown20: number;
  public Unknown21: number;
  public Unknown22: boolean;
  public Unknown23: number;
  public Unknown24: number;
  public Unknown25: number;
  public Unknown26: number;
  public Unknown27: number;
  public Unknown28: number;
  public Unknown29: boolean;
  public Unknown30: boolean;
  public Unknown31: boolean;
  public EnableGlobalUnit: boolean;
  public Unknown32: number;
  public Unknown33: number;
  public Countermeasures: number;
  public CraftExplosionTime: number;
  public Status2: number;
  public GlobalUnit: number;
  public OptionalWarheads: number[];
  public OptionalBeams: number[];
  public OptionalCountermeasures: number[];
  public OptionalCraftCategory: number;
  public OptionalCraft: number[];
  public NumberOfOptionalCraft: number[];
  public NumberofOptionalCraftWaves: number[];
  public PilotID: string;
  public Backdrop: number;
  public Unknown34: boolean;
  public Unknown35: boolean;
  public Unknown36: boolean;
  public Unknown37: boolean;
  public Unknown38: boolean;
  public Unknown39: boolean;
  public Unknown40: boolean;
  public Unknown41: boolean;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getString(hex, 0x000, 20);
    this.EnableDesignation = getByte(hex, 0x014);
    this.EnableDesignation2 = getByte(hex, 0x015);
    this.Designation1 = getByte(hex, 0x016);
    this.Designation2 = getByte(hex, 0x017);
    this.Unknown1 = getByte(hex, 0x018);
    this.GlobalCargoIndex = getByte(hex, 0x019);
    this.GlobalSpecialCargoIndex = getByte(hex, 0x01A);
    this.Cargo = getString(hex, 0x028, 20);
    this.SpecialCargo = getString(hex, 0x03C, 20);
    this.CraftRole = getString(hex, 0x050, 20);
    this.SpecialCargoCraft = getByte(hex, 0x069);
    this.RandomSpecialCargoCraft = getBool(hex, 0x06A);
    this.CraftType = getByte(hex, 0x06B);
    this.NumberOfCraft = getByte(hex, 0x06C);
    this.Status1 = getByte(hex, 0x06D);
    this.Warhead = getByte(hex, 0x06E);
    this.Beam = getByte(hex, 0x06F);
    this.Iff = getByte(hex, 0x070);
    this.Team = getByte(hex, 0x071);
    this.GroupAI = getByte(hex, 0x072);
    this.Markings = getByte(hex, 0x073);
    this.Radio = getByte(hex, 0x074);
    this.Formation = getByte(hex, 0x076);
    this.FormationSpacing = getByte(hex, 0x077);
    this.GlobalGroup = getByte(hex, 0x078);
    this.LeaderSpacing = getByte(hex, 0x079);
    this.NumberOfWaves = getByte(hex, 0x07A);
    this.Unknown3 = getByte(hex, 0x07B);
    this.PlayerNumber = getByte(hex, 0x07D);
    this.ArriveOnlyIfHuman = getBool(hex, 0x07E);
    this.PlayerCraft = getByte(hex, 0x07F);
    this.Yaw = getByte(hex, 0x080);
    this.Pitch = getByte(hex, 0x081);
    this.Roll = getByte(hex, 0x082);
    this.Unknown4 = getByte(hex, 0x084);
    this.Unknown5 = getByte(hex, 0x086);
    this.ArrivalDifficulty = getByte(hex, 0x087);
    this.Arrival1 = new Trigger(hex.slice(0x088), this.TIE);
    this.Arrival2 = new Trigger(hex.slice(0x08E), this.TIE);
    this.Arrival1OrArrival2 = getBool(hex, 0x096);
    this.Unknown6 = getBool(hex, 0x097);
    this.Arrival3 = new Trigger(hex.slice(0x098), this.TIE);
    this.Arrival4 = new Trigger(hex.slice(0x09E), this.TIE);
    this.Arrival3OrArrival4 = getBool(hex, 0x0A6);
    this.Arrivals12OrArrivals34 = getBool(hex, 0x0A8);
    this.ArrivalDelayMinutes = getByte(hex, 0x0AA);
    this.ArrivalDelaySeconds = getByte(hex, 0x0AB);
    this.Departure1 = new Trigger(hex.slice(0x0AC), this.TIE);
    this.Departure2 = new Trigger(hex.slice(0x0B2), this.TIE);
    this.Departure1OrDeparture2 = getBool(hex, 0x0BA);
    this.DepartureDelayMinutes = getByte(hex, 0x0BC);
    this.DepartureDelaySeconds = getByte(hex, 0x0BD);
    this.AbortTrigger = getByte(hex, 0x0BE);
    this.Unknown7 = getByte(hex, 0x0BF);
    this.Unknown8 = getByte(hex, 0x0C0);
    this.ArrivalMothership = getByte(hex, 0x0C2);
    this.ArriveViaMothership = getBool(hex, 0x0C3);
    this.DepartureMothership = getByte(hex, 0x0C4);
    this.DepartViaMothership = getBool(hex, 0x0C5);
    this.AlternateArrivalMothership = getByte(hex, 0x0C6);
    this.AlternateArriveViaMothership = getBool(hex, 0x0C7);
    this.AlternateDepartureMothership = getByte(hex, 0x0C8);
    this.AlternateDepartViaMothership = getBool(hex, 0x0C9);
    this.Orders = [];
    offset = 0x0CA;
    for (let i = 0; i < 16; i++) {
      const t = new Order(hex.slice(offset), this.TIE);
      this.Orders.push(t);
      offset += t.getLength();
    }
    this.Skips = [];
    offset = 0xA0A;
    for (let i = 0; i < 16; i++) {
      const t = new Skip(hex.slice(offset), this.TIE);
      this.Skips.push(t);
      offset += t.getLength();
    }
    this.Goals = [];
    offset = 0xB0A;
    for (let i = 0; i < 8; i++) {
      const t = new GoalFG(hex.slice(offset), this.TIE);
      this.Goals.push(t);
      offset += t.getLength();
    }
    this.StartPoints = [];
    offset = 0xD8A;
    for (let i = 0; i < 3; i++) {
      const t = new Waypt(hex.slice(offset), this.TIE);
      this.StartPoints.push(t);
      offset += t.getLength();
    }
    this.HyperPoint = new Waypt(hex.slice(0xDA2), this.TIE);
    this.StartPointRegions = [];
    offset = 0xDAA;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.StartPointRegions.push(t);
      offset += 1;
    }
    this.HyperPointRegion = getByte(hex, 0xDAD);
    this.Unknown16 = getByte(hex, 0xDAE);
    this.Unknown17 = getByte(hex, 0xDAF);
    this.Unknown18 = getByte(hex, 0xDB0);
    this.Unknown19 = getByte(hex, 0xDB1);
    this.Unknown20 = getByte(hex, 0xDB2);
    this.Unknown21 = getByte(hex, 0xDB3);
    this.Unknown22 = getBool(hex, 0xDB4);
    this.Unknown23 = getByte(hex, 0xDB6);
    this.Unknown24 = getByte(hex, 0xDB7);
    this.Unknown25 = getByte(hex, 0xDB8);
    this.Unknown26 = getByte(hex, 0xDB9);
    this.Unknown27 = getByte(hex, 0xDBA);
    this.Unknown28 = getByte(hex, 0xDBB);
    this.Unknown29 = getBool(hex, 0xDBC);
    this.Unknown30 = getBool(hex, 0xDC0);
    this.Unknown31 = getBool(hex, 0xDC1);
    this.EnableGlobalUnit = getBool(hex, 0xDC4);
    this.Unknown32 = getByte(hex, 0xDC5);
    this.Unknown33 = getByte(hex, 0xDC6);
    this.Countermeasures = getByte(hex, 0xDC7);
    this.CraftExplosionTime = getByte(hex, 0xDC8);
    this.Status2 = getByte(hex, 0xDC9);
    this.GlobalUnit = getByte(hex, 0xDCA);
    this.OptionalWarheads = [];
    offset = 0xDCC;
    for (let i = 0; i < 8; i++) {
      const t = getByte(hex, offset);
      this.OptionalWarheads.push(t);
      offset += 1;
    }
    this.OptionalBeams = [];
    offset = 0xDD4;
    for (let i = 0; i < 4; i++) {
      const t = getByte(hex, offset);
      this.OptionalBeams.push(t);
      offset += 1;
    }
    this.OptionalCountermeasures = [];
    offset = 0xDDA;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.OptionalCountermeasures.push(t);
      offset += 1;
    }
    this.OptionalCraftCategory = getByte(hex, 0xDDE);
    this.OptionalCraft = [];
    offset = 0xDDF;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.OptionalCraft.push(t);
      offset += 1;
    }
    this.NumberOfOptionalCraft = [];
    offset = 0xDE9;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.NumberOfOptionalCraft.push(t);
      offset += 1;
    }
    this.NumberofOptionalCraftWaves = [];
    offset = 0xDF3;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.NumberofOptionalCraftWaves.push(t);
      offset += 1;
    }
    this.PilotID = getString(hex, 0xDFD, 16);
    this.Backdrop = getByte(hex, 0xE12);
    this.Unknown34 = getBool(hex, 0xE29);
    this.Unknown35 = getBool(hex, 0xE2B);
    this.Unknown36 = getBool(hex, 0xE2D);
    this.Unknown37 = getBool(hex, 0xE2F);
    this.Unknown38 = getBool(hex, 0xE31);
    this.Unknown39 = getBool(hex, 0xE33);
    this.Unknown40 = getBool(hex, 0xE35);
    this.Unknown41 = getBool(hex, 0xE37);
    
  }
  
  public toJSON(): object {
    return {
      Name: this.Name,
      EnableDesignation: this.EnableDesignation,
      EnableDesignation2: this.EnableDesignation2,
      Designation1: this.Designation1Label,
      Designation2: this.Designation2Label,
      Unknown1: this.Unknown1,
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
      FormationSpacing: this.FormationSpacing,
      GlobalGroup: this.GlobalGroup,
      LeaderSpacing: this.LeaderSpacing,
      NumberOfWaves: this.NumberOfWaves,
      Unknown3: this.Unknown3,
      PlayerNumber: this.PlayerNumber,
      ArriveOnlyIfHuman: this.ArriveOnlyIfHuman,
      PlayerCraft: this.PlayerCraft,
      Yaw: this.Yaw,
      Pitch: this.Pitch,
      Roll: this.Roll,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5,
      ArrivalDifficulty: this.ArrivalDifficultyLabel,
      Arrival1: this.Arrival1,
      Arrival2: this.Arrival2,
      Arrival1OrArrival2: this.Arrival1OrArrival2,
      Unknown6: this.Unknown6,
      Arrival3: this.Arrival3,
      Arrival4: this.Arrival4,
      Arrival3OrArrival4: this.Arrival3OrArrival4,
      Arrivals12OrArrivals34: this.Arrivals12OrArrivals34,
      ArrivalDelayMinutes: this.ArrivalDelayMinutes,
      ArrivalDelaySeconds: this.ArrivalDelaySeconds,
      Departure1: this.Departure1,
      Departure2: this.Departure2,
      Departure1OrDeparture2: this.Departure1OrDeparture2,
      DepartureDelayMinutes: this.DepartureDelayMinutes,
      DepartureDelaySeconds: this.DepartureDelaySeconds,
      AbortTrigger: this.AbortTriggerLabel,
      Unknown7: this.Unknown7,
      Unknown8: this.Unknown8,
      ArrivalMothership: this.ArrivalMothership,
      ArriveViaMothership: this.ArriveViaMothership,
      DepartureMothership: this.DepartureMothership,
      DepartViaMothership: this.DepartViaMothership,
      AlternateArrivalMothership: this.AlternateArrivalMothership,
      AlternateArriveViaMothership: this.AlternateArriveViaMothership,
      AlternateDepartureMothership: this.AlternateDepartureMothership,
      AlternateDepartViaMothership: this.AlternateDepartViaMothership,
      Orders: this.Orders,
      Skips: this.Skips,
      Goals: this.Goals,
      StartPoints: this.StartPoints,
      HyperPoint: this.HyperPoint,
      StartPointRegions: this.StartPointRegions,
      HyperPointRegion: this.HyperPointRegion,
      Unknown16: this.Unknown16,
      Unknown17: this.Unknown17,
      Unknown18: this.Unknown18,
      Unknown19: this.Unknown19,
      Unknown20: this.Unknown20,
      Unknown21: this.Unknown21,
      Unknown22: this.Unknown22,
      Unknown23: this.Unknown23,
      Unknown24: this.Unknown24,
      Unknown25: this.Unknown25,
      Unknown26: this.Unknown26,
      Unknown27: this.Unknown27,
      Unknown28: this.Unknown28,
      Unknown29: this.Unknown29,
      Unknown30: this.Unknown30,
      Unknown31: this.Unknown31,
      EnableGlobalUnit: this.EnableGlobalUnit,
      Unknown32: this.Unknown32,
      Unknown33: this.Unknown33,
      Countermeasures: this.Countermeasures,
      CraftExplosionTime: this.CraftExplosionTime,
      Status2: this.Status2Label,
      GlobalUnit: this.GlobalUnit,
      OptionalWarheads: this.OptionalWarheads,
      OptionalBeams: this.OptionalBeams,
      OptionalCountermeasures: this.OptionalCountermeasures,
      OptionalCraftCategory: this.OptionalCraftCategory,
      OptionalCraft: this.OptionalCraft,
      NumberOfOptionalCraft: this.NumberOfOptionalCraft,
      NumberofOptionalCraftWaves: this.NumberofOptionalCraftWaves,
      PilotID: this.PilotID,
      Backdrop: this.Backdrop,
      Unknown34: this.Unknown34,
      Unknown35: this.Unknown35,
      Unknown36: this.Unknown36,
      Unknown37: this.Unknown37,
      Unknown38: this.Unknown38,
      Unknown39: this.Unknown39,
      Unknown40: this.Unknown40,
      Unknown41: this.Unknown41
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeString(hex, this.Name, 0x000);
    writeByte(hex, this.EnableDesignation, 0x014);
    writeByte(hex, this.EnableDesignation2, 0x015);
    writeByte(hex, this.Designation1, 0x016);
    writeByte(hex, this.Designation2, 0x017);
    writeByte(hex, this.Unknown1, 0x018);
    writeByte(hex, this.GlobalCargoIndex, 0x019);
    writeByte(hex, this.GlobalSpecialCargoIndex, 0x01A);
    writeString(hex, this.Cargo, 0x028);
    writeString(hex, this.SpecialCargo, 0x03C);
    writeString(hex, this.CraftRole, 0x050);
    writeByte(hex, this.SpecialCargoCraft, 0x069);
    writeBool(hex, this.RandomSpecialCargoCraft, 0x06A);
    writeByte(hex, this.CraftType, 0x06B);
    writeByte(hex, this.NumberOfCraft, 0x06C);
    writeByte(hex, this.Status1, 0x06D);
    writeByte(hex, this.Warhead, 0x06E);
    writeByte(hex, this.Beam, 0x06F);
    writeByte(hex, this.Iff, 0x070);
    writeByte(hex, this.Team, 0x071);
    writeByte(hex, this.GroupAI, 0x072);
    writeByte(hex, this.Markings, 0x073);
    writeByte(hex, this.Radio, 0x074);
    writeByte(hex, this.Formation, 0x076);
    writeByte(hex, this.FormationSpacing, 0x077);
    writeByte(hex, this.GlobalGroup, 0x078);
    writeByte(hex, this.LeaderSpacing, 0x079);
    writeByte(hex, this.NumberOfWaves, 0x07A);
    writeByte(hex, this.Unknown3, 0x07B);
    writeByte(hex, this.PlayerNumber, 0x07D);
    writeBool(hex, this.ArriveOnlyIfHuman, 0x07E);
    writeByte(hex, this.PlayerCraft, 0x07F);
    writeByte(hex, this.Yaw, 0x080);
    writeByte(hex, this.Pitch, 0x081);
    writeByte(hex, this.Roll, 0x082);
    writeByte(hex, this.Unknown4, 0x084);
    writeByte(hex, this.Unknown5, 0x086);
    writeByte(hex, this.ArrivalDifficulty, 0x087);
    writeObject(hex, this.Arrival1, 0x088);
    writeObject(hex, this.Arrival2, 0x08E);
    writeBool(hex, this.Arrival1OrArrival2, 0x096);
    writeBool(hex, this.Unknown6, 0x097);
    writeObject(hex, this.Arrival3, 0x098);
    writeObject(hex, this.Arrival4, 0x09E);
    writeBool(hex, this.Arrival3OrArrival4, 0x0A6);
    writeBool(hex, this.Arrivals12OrArrivals34, 0x0A8);
    writeByte(hex, this.ArrivalDelayMinutes, 0x0AA);
    writeByte(hex, this.ArrivalDelaySeconds, 0x0AB);
    writeObject(hex, this.Departure1, 0x0AC);
    writeObject(hex, this.Departure2, 0x0B2);
    writeBool(hex, this.Departure1OrDeparture2, 0x0BA);
    writeByte(hex, this.DepartureDelayMinutes, 0x0BC);
    writeByte(hex, this.DepartureDelaySeconds, 0x0BD);
    writeByte(hex, this.AbortTrigger, 0x0BE);
    writeByte(hex, this.Unknown7, 0x0BF);
    writeByte(hex, this.Unknown8, 0x0C0);
    writeByte(hex, this.ArrivalMothership, 0x0C2);
    writeBool(hex, this.ArriveViaMothership, 0x0C3);
    writeByte(hex, this.DepartureMothership, 0x0C4);
    writeBool(hex, this.DepartViaMothership, 0x0C5);
    writeByte(hex, this.AlternateArrivalMothership, 0x0C6);
    writeBool(hex, this.AlternateArriveViaMothership, 0x0C7);
    writeByte(hex, this.AlternateDepartureMothership, 0x0C8);
    writeBool(hex, this.AlternateDepartViaMothership, 0x0C9);
    offset = 0x0CA;
    for (let i = 0; i < 16; i++) {
      const t = this.Orders[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xA0A;
    for (let i = 0; i < 16; i++) {
      const t = this.Skips[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xB0A;
    for (let i = 0; i < 8; i++) {
      const t = this.Goals[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0xD8A;
    for (let i = 0; i < 3; i++) {
      const t = this.StartPoints[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeObject(hex, this.HyperPoint, 0xDA2);
    offset = 0xDAA;
    for (let i = 0; i < 3; i++) {
      const t = this.StartPointRegions[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.HyperPointRegion, 0xDAD);
    writeByte(hex, this.Unknown16, 0xDAE);
    writeByte(hex, this.Unknown17, 0xDAF);
    writeByte(hex, this.Unknown18, 0xDB0);
    writeByte(hex, this.Unknown19, 0xDB1);
    writeByte(hex, this.Unknown20, 0xDB2);
    writeByte(hex, this.Unknown21, 0xDB3);
    writeBool(hex, this.Unknown22, 0xDB4);
    writeByte(hex, this.Unknown23, 0xDB6);
    writeByte(hex, this.Unknown24, 0xDB7);
    writeByte(hex, this.Unknown25, 0xDB8);
    writeByte(hex, this.Unknown26, 0xDB9);
    writeByte(hex, this.Unknown27, 0xDBA);
    writeByte(hex, this.Unknown28, 0xDBB);
    writeBool(hex, this.Unknown29, 0xDBC);
    writeBool(hex, this.Unknown30, 0xDC0);
    writeBool(hex, this.Unknown31, 0xDC1);
    writeBool(hex, this.EnableGlobalUnit, 0xDC4);
    writeByte(hex, this.Unknown32, 0xDC5);
    writeByte(hex, this.Unknown33, 0xDC6);
    writeByte(hex, this.Countermeasures, 0xDC7);
    writeByte(hex, this.CraftExplosionTime, 0xDC8);
    writeByte(hex, this.Status2, 0xDC9);
    writeByte(hex, this.GlobalUnit, 0xDCA);
    offset = 0xDCC;
    for (let i = 0; i < 8; i++) {
      const t = this.OptionalWarheads[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xDD4;
    for (let i = 0; i < 4; i++) {
      const t = this.OptionalBeams[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xDDA;
    for (let i = 0; i < 3; i++) {
      const t = this.OptionalCountermeasures[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.OptionalCraftCategory, 0xDDE);
    offset = 0xDDF;
    for (let i = 0; i < 10; i++) {
      const t = this.OptionalCraft[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xDE9;
    for (let i = 0; i < 10; i++) {
      const t = this.NumberOfOptionalCraft[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0xDF3;
    for (let i = 0; i < 10; i++) {
      const t = this.NumberofOptionalCraftWaves[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeString(hex, this.PilotID, 0xDFD);
    writeByte(hex, this.Backdrop, 0xE12);
    writeBool(hex, this.Unknown34, 0xE29);
    writeBool(hex, this.Unknown35, 0xE2B);
    writeBool(hex, this.Unknown36, 0xE2D);
    writeBool(hex, this.Unknown37, 0xE2F);
    writeBool(hex, this.Unknown38, 0xE31);
    writeBool(hex, this.Unknown39, 0xE33);
    writeBool(hex, this.Unknown40, 0xE35);
    writeBool(hex, this.Unknown41, 0xE37);

    return hex;
  }
  
  public get Designation1Label(): string {
    return Constants.DESIGNATION[this.Designation1] || "Unknown";
  }

  public get Designation2Label(): string {
    return Constants.DESIGNATION[this.Designation2] || "Unknown";
  }

  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || "Unknown";
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
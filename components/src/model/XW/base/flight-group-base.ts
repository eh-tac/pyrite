import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public readonly FLIGHTGROUPLENGTH: number = 148;
  public Name: string[];
  public Cargo: string[];
  public SpecialCargo: string[];
  public SpecialCargoCraft: number;
  public CraftType: number;
  public IFF: number;
  public FlightGroupStatus: number; //(unusual formatting)
  public NumberOfCraft: number;
  public NumberOfWaves: number;
  public ArrivalEvent: number;
  public ArrivalDelay: number; //(unusual formatting)
  public ArrivalFG: number; //(-1 for none)
  public Mothership: number; //(-1 for none)
  public ArrivalHyperspace: number;
  public DepartureHyperspace: number;
  public Waypoint: number[]; //(Enabled)
  public Formation: number;
  public PlayerCraft: number;
  public GroupAI: number;
  public Order: number;
  public OrderValue: number; //(dock time or throttle)
  public Markings: number;
  public Objective: number;
  public TargetPrimary: number; //(-1 for none)
  public TargetSecondary: number; //(-1 for none)
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Name = [];
    offset = 0x000;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.Name.push(t);
      offset += 1;
    }
    this.Cargo = [];
    offset = 0x010;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.Cargo.push(t);
      offset += 1;
    }
    this.SpecialCargo = [];
    offset = 0x020;
    for (let i = 0; i < 16; i++) {
      const t = getChar(hex, offset, 1);
      this.SpecialCargo.push(t);
      offset += 1;
    }
    this.SpecialCargoCraft = getShort(hex, 0x030);
    this.CraftType = getShort(hex, 0x032);
    this.IFF = getShort(hex, 0x034);
    this.FlightGroupStatus = getShort(hex, 0x036);
    this.NumberOfCraft = getShort(hex, 0x038);
    this.NumberOfWaves = getShort(hex, 0x03A);
    this.ArrivalEvent = getShort(hex, 0x03C);
    this.ArrivalDelay = getShort(hex, 0x03E);
    this.ArrivalFG = getShort(hex, 0x040);
    this.Mothership = getShort(hex, 0x042);
    this.ArrivalHyperspace = getShort(hex, 0x044);
    this.DepartureHyperspace = getShort(hex, 0x046);
    this.Waypoint = [];
    offset = 0x072;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.Waypoint.push(t);
      offset += 2;
    }
    this.Formation = getShort(hex, 0x080);
    this.PlayerCraft = getShort(hex, 0x082);
    this.GroupAI = getShort(hex, 0x084);
    this.Order = getShort(hex, 0x086);
    this.OrderValue = getShort(hex, 0x088);
    this.Markings = getShort(hex, 0x08C);
    this.Objective = getShort(hex, 0x08E);
    this.TargetPrimary = getShort(hex, 0x090);
    this.TargetSecondary = getShort(hex, 0x092);
    
  }
  
  public toJSON(): object {
    return {
      Name: this.Name,
      Cargo: this.Cargo,
      SpecialCargo: this.SpecialCargo,
      SpecialCargoCraft: this.SpecialCargoCraft,
      CraftType: this.CraftTypeLabel,
      IFF: this.IFFLabel,
      FlightGroupStatus: this.FlightGroupStatusLabel,
      NumberOfCraft: this.NumberOfCraft,
      NumberOfWaves: this.NumberOfWaves,
      ArrivalEvent: this.ArrivalEventLabel,
      ArrivalDelay: this.ArrivalDelay,
      ArrivalFG: this.ArrivalFG,
      Mothership: this.Mothership,
      ArrivalHyperspace: this.ArrivalHyperspace,
      DepartureHyperspace: this.DepartureHyperspace,
      Waypoint: this.Waypoint,
      Formation: this.FormationLabel,
      PlayerCraft: this.PlayerCraft,
      GroupAI: this.GroupAILabel,
      Order: this.OrderLabel,
      OrderValue: this.OrderValue,
      Markings: this.MarkingsLabel,
      Objective: this.ObjectiveLabel,
      TargetPrimary: this.TargetPrimary,
      TargetSecondary: this.TargetSecondary
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    offset = 0x000;
    for (let i = 0; i < 16; i++) {
      const t = this.Name[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    offset = 0x010;
    for (let i = 0; i < 16; i++) {
      const t = this.Cargo[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    offset = 0x020;
    for (let i = 0; i < 16; i++) {
      const t = this.SpecialCargo[i];
      writeChar(hex, t, offset);
      offset += 1;
    }
    writeShort(hex, this.SpecialCargoCraft, 0x030);
    writeShort(hex, this.CraftType, 0x032);
    writeShort(hex, this.IFF, 0x034);
    writeShort(hex, this.FlightGroupStatus, 0x036);
    writeShort(hex, this.NumberOfCraft, 0x038);
    writeShort(hex, this.NumberOfWaves, 0x03A);
    writeShort(hex, this.ArrivalEvent, 0x03C);
    writeShort(hex, this.ArrivalDelay, 0x03E);
    writeShort(hex, this.ArrivalFG, 0x040);
    writeShort(hex, this.Mothership, 0x042);
    writeShort(hex, this.ArrivalHyperspace, 0x044);
    writeShort(hex, this.DepartureHyperspace, 0x046);
    offset = 0x072;
    for (let i = 0; i < 7; i++) {
      const t = this.Waypoint[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    writeShort(hex, this.Formation, 0x080);
    writeShort(hex, this.PlayerCraft, 0x082);
    writeShort(hex, this.GroupAI, 0x084);
    writeShort(hex, this.Order, 0x086);
    writeShort(hex, this.OrderValue, 0x088);
    writeShort(hex, this.Markings, 0x08C);
    writeShort(hex, this.Objective, 0x08E);
    writeShort(hex, this.TargetPrimary, 0x090);
    writeShort(hex, this.TargetSecondary, 0x092);

    return hex;
  }
  
  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || "Unknown";
  }

  public get IFFLabel(): string {
    return Constants.IFF[this.IFF] || "Unknown";
  }

  public get FlightGroupStatusLabel(): string {
    return Constants.FLIGHTGROUPSTATUS[this.FlightGroupStatus] || "Unknown";
  }

  public get ArrivalEventLabel(): string {
    return Constants.ARRIVALEVENT[this.ArrivalEvent] || "Unknown";
  }

  public get FormationLabel(): string {
    return Constants.FORMATION[this.Formation] || "Unknown";
  }

  public get GroupAILabel(): string {
    return Constants.GROUPAI[this.GroupAI] || "Unknown";
  }

  public get OrderLabel(): string {
    return Constants.ORDER[this.Order] || "Unknown";
  }

  public get MarkingsLabel(): string {
    return Constants.MARKINGS[this.Markings] || "Unknown";
  }

  public get ObjectiveLabel(): string {
    return Constants.OBJECTIVE[this.Objective] || "Unknown";
  }
  
  public getLength(): number {
    return this.FLIGHTGROUPLENGTH;
  }
}
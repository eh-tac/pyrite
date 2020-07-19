import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, getString, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public readonly FLIGHTGROUPLENGTH: number = 148;
  public Name: string;
  public Cargo: string;
  public SpecialCargo: string;
  public SpecialCargoCraft: number;
  public CraftType: number;
  public IFF: number;
  public FlightGroupStatus: number;
  public NumberOfCraft: number;
  public NumberOfWaves: number;
  public ArrivalEvent: number;
  public ArrivalDelay: number;
  public ArrivalFlightGroup: number;
  public MothershipFlightGroup: number;
  public ArriveByHyperspace: number;
  public DepartByHyperspace: number;
  public XCoordinates: number[];
  public YCoordinates: number[];
  public ZCoordinates: number[];
  public CoordinatesEnabled: number[];
  public Formation: number;
  public PlayerCraft: number;
  public CraftAI: number;
  public Order: number;
  public OrderVariable: number;
  public CraftColour: number;
  public readonly Reserved: number = 0;
  public CraftObjective: number;
  public PrimaryTarget: number;
  public SecondaryTarget: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getString(hex, 0x00);
    this.Cargo = getString(hex, 0x10);
    this.SpecialCargo = getString(hex, 0x20);
    this.SpecialCargoCraft = getShort(hex, 0x30);
    this.CraftType = getShort(hex, 0x32);
    this.IFF = getShort(hex, 0x34);
    this.FlightGroupStatus = getShort(hex, 0x36);
    this.NumberOfCraft = getShort(hex, 0x38);
    this.NumberOfWaves = getShort(hex, 0x3A);
    this.ArrivalEvent = getShort(hex, 0x3C);
    this.ArrivalDelay = getShort(hex, 0x3E);
    this.ArrivalFlightGroup = getShort(hex, 0x40);
    this.MothershipFlightGroup = getShort(hex, 0x42);
    this.ArriveByHyperspace = getShort(hex, 0x44);
    this.DepartByHyperspace = getShort(hex, 0x46);
    this.XCoordinates = [];
    offset = 0x48;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.XCoordinates.push(t);
      offset += 2;
    }
    this.YCoordinates = [];
    offset = 0x56;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.YCoordinates.push(t);
      offset += 2;
    }
    this.ZCoordinates = [];
    offset = 0x64;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.ZCoordinates.push(t);
      offset += 2;
    }
    this.CoordinatesEnabled = [];
    offset = 0x72;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.CoordinatesEnabled.push(t);
      offset += 2;
    }
    this.Formation = getShort(hex, 0x80);
    this.PlayerCraft = getShort(hex, 0x82);
    this.CraftAI = getShort(hex, 0x84);
    this.Order = getShort(hex, 0x86);
    this.OrderVariable = getShort(hex, 0x88);
    this.CraftColour = getShort(hex, 0x8A);
    // static prop Reserved
    this.CraftObjective = getShort(hex, 0x8E);
    this.PrimaryTarget = getShort(hex, 0x90);
    this.SecondaryTarget = getShort(hex, 0x92);
    
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
      ArrivalFlightGroup: this.ArrivalFlightGroup,
      MothershipFlightGroup: this.MothershipFlightGroup,
      ArriveByHyperspace: this.ArriveByHyperspace,
      DepartByHyperspace: this.DepartByHyperspace,
      XCoordinates: this.XCoordinates,
      YCoordinates: this.YCoordinates,
      ZCoordinates: this.ZCoordinates,
      CoordinatesEnabled: this.CoordinatesEnabled,
      Formation: this.FormationLabel,
      PlayerCraft: this.PlayerCraft,
      CraftAI: this.CraftAILabel,
      Order: this.OrderLabel,
      OrderVariable: this.OrderVariable,
      CraftColour: this.CraftColourLabel,
      CraftObjective: this.CraftObjectiveLabel,
      PrimaryTarget: this.PrimaryTarget,
      SecondaryTarget: this.SecondaryTarget
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeString(hex, this.Name, 0x00);
    writeString(hex, this.Cargo, 0x10);
    writeString(hex, this.SpecialCargo, 0x20);
    writeShort(hex, this.SpecialCargoCraft, 0x30);
    writeShort(hex, this.CraftType, 0x32);
    writeShort(hex, this.IFF, 0x34);
    writeShort(hex, this.FlightGroupStatus, 0x36);
    writeShort(hex, this.NumberOfCraft, 0x38);
    writeShort(hex, this.NumberOfWaves, 0x3A);
    writeShort(hex, this.ArrivalEvent, 0x3C);
    writeShort(hex, this.ArrivalDelay, 0x3E);
    writeShort(hex, this.ArrivalFlightGroup, 0x40);
    writeShort(hex, this.MothershipFlightGroup, 0x42);
    writeShort(hex, this.ArriveByHyperspace, 0x44);
    writeShort(hex, this.DepartByHyperspace, 0x46);
    offset = 0x48;
    for (let i = 0; i < 7; i++) {
      const t = this.XCoordinates[i];
      writeShort(hex, t, 0x48);
      offset += 2;
    }
    offset = 0x56;
    for (let i = 0; i < 7; i++) {
      const t = this.YCoordinates[i];
      writeShort(hex, t, 0x56);
      offset += 2;
    }
    offset = 0x64;
    for (let i = 0; i < 7; i++) {
      const t = this.ZCoordinates[i];
      writeShort(hex, t, 0x64);
      offset += 2;
    }
    offset = 0x72;
    for (let i = 0; i < 7; i++) {
      const t = this.CoordinatesEnabled[i];
      writeShort(hex, t, 0x72);
      offset += 2;
    }
    writeShort(hex, this.Formation, 0x80);
    writeShort(hex, this.PlayerCraft, 0x82);
    writeShort(hex, this.CraftAI, 0x84);
    writeShort(hex, this.Order, 0x86);
    writeShort(hex, this.OrderVariable, 0x88);
    writeShort(hex, this.CraftColour, 0x8A);
    writeShort(hex, 0, 0x8C);
    writeShort(hex, this.CraftObjective, 0x8E);
    writeShort(hex, this.PrimaryTarget, 0x90);
    writeShort(hex, this.SecondaryTarget, 0x92);

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

  public get CraftAILabel(): string {
    return Constants.CRAFTAI[this.CraftAI] || "Unknown";
  }

  public get OrderLabel(): string {
    return Constants.ORDER[this.Order] || "Unknown";
  }

  public get CraftColourLabel(): string {
    return Constants.CRAFTCOLOUR[this.CraftColour] || "Unknown";
  }

  public get CraftObjectiveLabel(): string {
    return Constants.CRAFTOBJECTIVE[this.CraftObjective] || "Unknown";
  }
  
  public getLength(): number {
    return this.FLIGHTGROUPLENGTH;
  }
}
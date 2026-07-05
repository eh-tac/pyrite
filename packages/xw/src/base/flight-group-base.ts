import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getChar, getShort, writeChar, writeShort } from '@pyrite/core';

import type {
  ArrivalEvent,
  CraftType,
  FlightGroupStatus,
  Formation,
  GroupAI,
  IFF,
  Markings,
  Objective,
  Order
} from '../constants';
import {
  Constants
} from '../constants';
export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public readonly FLIGHTGROUPLENGTH: number = 148;
  public Name: string;
  public Cargo: string;
  public SpecialCargo: string;
  public SpecialCargoCraft: number;
  public CraftType: CraftType;
  public IFF: IFF;
  public FlightGroupStatus: FlightGroupStatus; //(unusual formatting)
  public NumberOfCraft: number;
  public NumberOfWaves: number;
  public ArrivalEvent: ArrivalEvent;
  public ArrivalDelay: number; //(unusual formatting)
  public ArrivalFG: number; //(-1 for none)
  public Mothership: number; //(-1 for none)
  public ArrivalHyperspace: number;
  public DepartureHyperspace: number;
  public WaypointX: number[];
  public WaypointY: number[];
  public WaypointZ: number[];
  public WaypointEnabled: number[];
  public Formation: Formation;
  public PlayerCraft: number;
  public GroupAI: GroupAI;
  public Order: Order;
  public OrderValue: number; //(dock time or throttle)
  public Markings: Markings;
  public Objective: Objective;
  public TargetPrimary: number; //(-1 for none)
  public TargetSecondary: number; //(-1 for none)

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getChar(hex, 0x000, 16);
    this.Cargo = getChar(hex, 0x010, 16);
    this.SpecialCargo = getChar(hex, 0x020, 16);
    this.SpecialCargoCraft = getShort(hex, 0x030);
    this.CraftType = getShort(hex, 0x032) as CraftType;
    this.IFF = getShort(hex, 0x034) as IFF;
    this.FlightGroupStatus = getShort(hex, 0x036) as FlightGroupStatus;
    this.NumberOfCraft = getShort(hex, 0x038);
    this.NumberOfWaves = getShort(hex, 0x03a);
    this.ArrivalEvent = getShort(hex, 0x03c) as ArrivalEvent;
    this.ArrivalDelay = getShort(hex, 0x03e);
    this.ArrivalFG = getShort(hex, 0x040);
    this.Mothership = getShort(hex, 0x042);
    this.ArrivalHyperspace = getShort(hex, 0x044);
    this.DepartureHyperspace = getShort(hex, 0x046);
    this.WaypointX = [];
    offset = 0x048;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.WaypointX.push(t);
      offset += 2;
    }
    this.WaypointY = [];
    offset = 0x056;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.WaypointY.push(t);
      offset += 2;
    }
    this.WaypointZ = [];
    offset = 0x064;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.WaypointZ.push(t);
      offset += 2;
    }
    this.WaypointEnabled = [];
    offset = 0x072;
    for (let i = 0; i < 7; i++) {
      const t = getShort(hex, offset);
      this.WaypointEnabled.push(t);
      offset += 2;
    }
    this.Formation = getShort(hex, 0x080) as Formation;
    this.PlayerCraft = getShort(hex, 0x082);
    this.GroupAI = getShort(hex, 0x084) as GroupAI;
    this.Order = getShort(hex, 0x086) as Order;
    this.OrderValue = getShort(hex, 0x088);
    this.Markings = getShort(hex, 0x08c) as Markings;
    this.Objective = getShort(hex, 0x08e) as Objective;
    this.TargetPrimary = getShort(hex, 0x090);
    this.TargetSecondary = getShort(hex, 0x092);
  }

  public toJSON(): Record<string, unknown> | string {
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
      WaypointX: this.WaypointX,
      WaypointY: this.WaypointY,
      WaypointZ: this.WaypointZ,
      WaypointEnabled: this.WaypointEnabled,
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

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeChar(hex, this.Name, 0x000, 16);
    writeChar(hex, this.Cargo, 0x010, 16);
    writeChar(hex, this.SpecialCargo, 0x020, 16);
    writeShort(hex, this.SpecialCargoCraft, 0x030);
    writeShort(hex, this.CraftType, 0x032);
    writeShort(hex, this.IFF, 0x034);
    writeShort(hex, this.FlightGroupStatus, 0x036);
    writeShort(hex, this.NumberOfCraft, 0x038);
    writeShort(hex, this.NumberOfWaves, 0x03a);
    writeShort(hex, this.ArrivalEvent, 0x03c);
    writeShort(hex, this.ArrivalDelay, 0x03e);
    writeShort(hex, this.ArrivalFG, 0x040);
    writeShort(hex, this.Mothership, 0x042);
    writeShort(hex, this.ArrivalHyperspace, 0x044);
    writeShort(hex, this.DepartureHyperspace, 0x046);
    offset = 0x048;
    for (let i = 0; i < this.WaypointX.length; i++) {
      const t = this.WaypointX[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    offset = 0x056;
    for (let i = 0; i < this.WaypointY.length; i++) {
      const t = this.WaypointY[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    offset = 0x064;
    for (let i = 0; i < this.WaypointZ.length; i++) {
      const t = this.WaypointZ[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    offset = 0x072;
    for (let i = 0; i < this.WaypointEnabled.length; i++) {
      const t = this.WaypointEnabled[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    writeShort(hex, this.Formation, 0x080);
    writeShort(hex, this.PlayerCraft, 0x082);
    writeShort(hex, this.GroupAI, 0x084);
    writeShort(hex, this.Order, 0x086);
    writeShort(hex, this.OrderValue, 0x088);
    writeShort(hex, this.Markings, 0x08c);
    writeShort(hex, this.Objective, 0x08e);
    writeShort(hex, this.TargetPrimary, 0x090);
    writeShort(hex, this.TargetSecondary, 0x092);

    return hex;
  }

  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || 'Unknown';
  }

  public get IFFLabel(): string {
    return Constants.IFF[this.IFF] || 'Unknown';
  }

  public get FlightGroupStatusLabel(): string {
    return Constants.FLIGHTGROUPSTATUS[this.FlightGroupStatus] || 'Unknown';
  }

  public get ArrivalEventLabel(): string {
    return Constants.ARRIVALEVENT[this.ArrivalEvent] || 'Unknown';
  }

  public get FormationLabel(): string {
    return Constants.FORMATION[this.Formation] || 'Unknown';
  }

  public get GroupAILabel(): string {
    return Constants.GROUPAI[this.GroupAI] || 'Unknown';
  }

  public get OrderLabel(): string {
    return Constants.ORDER[this.Order] || 'Unknown';
  }

  public get MarkingsLabel(): string {
    return Constants.MARKINGS[this.Markings] || 'Unknown';
  }

  public get ObjectiveLabel(): string {
    return Constants.OBJECTIVE[this.Objective] || 'Unknown';
  }

  public getLength(): number {
    return this.FLIGHTGROUPLENGTH;
  }
}

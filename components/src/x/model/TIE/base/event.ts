import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class EventBase extends PyriteBase implements Byteable {
  public EventLength:number;
  public Time:number;
  public EventType:number;
  public Variables:number[];

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }

  public get EventTypeLabel(): string {
    return Constants.EVENTTYPE[this.EventType] || "Unknown";
  }
}
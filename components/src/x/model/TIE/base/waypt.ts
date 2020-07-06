import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class WayptBase extends PyriteBase implements Byteable {
  public static WAYPTLENGTH:number = 30;
  public StartPoints:number[];
  public Waypoints:number[];
  public Rendezvous:number;
  public Hyperspace:number;
  public Briefing:number;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }
}
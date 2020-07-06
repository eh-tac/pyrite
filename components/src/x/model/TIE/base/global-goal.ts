import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GlobalGoalBase extends PyriteBase implements Byteable {
  public static GLOBALGOALLENGTH:number = 28;
  public Triggers:Trigger[];
  public Trigger1OrTrigger2:boolean;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }
}
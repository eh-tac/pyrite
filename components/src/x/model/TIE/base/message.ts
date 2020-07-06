import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MessageBase extends PyriteBase implements Byteable {
  public static MESSAGELENGTH:number = 90;
  public Message:string;
  public Triggers:Trigger[];
  public EditorNote:string;
  public DelaySeconds:number;
  public Trigger1OrTrigger2:boolean;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }
}
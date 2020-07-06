import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PreMissionQuestionsBase extends PyriteBase implements Byteable {
  public PreMissionQuestionsLength:number;
  public Length:number;
  public Question:string;
  public static Spacer:number = 10;
  public Answer:string;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }
}
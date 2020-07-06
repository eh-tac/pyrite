import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PostMissionQuestionsBase extends PyriteBase implements Byteable {
  public PostMissionQuestionsLength:number;
  public Length:number;
  public QuestionCondition:number;
  public QuestionType:number;
  public Question:string;
  public static Spacer:number = 10;
  public Answer:string;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }

  public get QuestionConditionLabel(): string {
    return Constants.QUESTIONCONDITION[this.QuestionCondition] || "Unknown";
  }

  public get QuestionTypeLabel(): string {
    return Constants.QUESTIONTYPE[this.QuestionType] || "Unknown";
  }
}
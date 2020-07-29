import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PostMissionQuestionsBase extends PyriteBase implements Byteable {
  public PostMissionQuestionsLength: number;
  public Length: number;
  public QuestionCondition: number;
  public QuestionType: number;
  public Question: string;
  public readonly Spacer: number = 10;
  public Answer: string;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.QuestionCondition = getByte(hex, 0x2);
    this.QuestionType = getByte(hex, 0x3);
    this.Question = getChar(hex, 0x4, this.QuestionLength());
    // static prop Spacer
    offset += 1;
    this.Answer = getChar(hex, offset, this.AnswerLength());
    this.PostMissionQuestionsLength = offset;
  }
  
  public toJSON(): object {
    return {
      Length: this.Length,
      QuestionCondition: this.QuestionConditionLabel,
      QuestionType: this.QuestionTypeLabel,
      Question: this.Question,
      Answer: this.Answer
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    writeByte(hex, this.QuestionCondition, 0x2);
    writeByte(hex, this.QuestionType, 0x3);
    writeChar(hex, this.Question, 0x4);
    writeByte(hex, 10, offset);
    writeChar(hex, this.Answer, offset);

    return hex;
  }
  
  public get QuestionConditionLabel(): string {
    return Constants.QUESTIONCONDITION[this.QuestionCondition] || "Unknown";
  }

  public get QuestionTypeLabel(): string {
    return Constants.QUESTIONTYPE[this.QuestionType] || "Unknown";
  }
  protected abstract QuestionLength();
protected abstract AnswerLength();
  public getLength(): number {
    return this.PostMissionQuestionsLength;
  }
}
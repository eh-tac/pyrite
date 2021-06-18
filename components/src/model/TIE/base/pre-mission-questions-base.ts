import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PreMissionQuestionsBase extends PyriteBase implements Byteable {
  public PreMissionQuestionsLength: number;
  public Length: number;
  public Question: string;
  public readonly Spacer: number = 10;
  public Answer: string;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.Question = getChar(hex, 0x2, this.QuestionLength());
    offset = 0x2 + this.QuestionLength();
    // static prop Spacer
    offset += 1;
    this.Answer = getChar(hex, offset, this.AnswerLength());
    offset += this.AnswerLength();
    this.PreMissionQuestionsLength = offset;
  }
  
  public toJSON(): object {
    return {
      Length: this.Length,
      Question: this.Question,
      Answer: this.Answer
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    writeChar(hex, this.Question, 0x2);
    writeByte(hex, 10, offset);
    writeChar(hex, this.Answer, offset);

    return hex;
  }
  
  protected abstract QuestionLength();
protected abstract AnswerLength();
  public getLength(): number {
    return this.PreMissionQuestionsLength;
  }
}
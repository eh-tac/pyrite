import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getChar, getShort, writeByte, writeChar, writeShort } from '@pyrite/core';
export abstract class PreMissionQuestionsBase extends PyriteBase implements Byteable {
  public PreMissionQuestionsLength: number;
  public Length: number;
  public Question: string;
  public readonly Spacer: number = 10;
  public Answer: string;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
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

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      Question: this.Question,
      Answer: this.Answer
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    writeChar(hex, this.Question, 0x2, this.QuestionLength());
    writeByte(hex, 10, offset);
    offset += 1;
    writeChar(hex, this.Answer, offset, this.AnswerLength());
    offset += this.AnswerLength();

    return hex;
  }

  protected abstract QuestionLength(): number;
  protected abstract AnswerLength(): number;
  public getLength(): number {
    return this.PreMissionQuestionsLength;
  }
}

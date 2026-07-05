import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from '@pyrite/core';

import type { QuestionCondition, QuestionType } from '../constants';
import { Constants } from '../constants';
export abstract class PostMissionQuestionsBase extends PyriteBase implements Byteable {
  public PostMissionQuestionsLength: number;
  public Length: number;
  public QuestionCondition: QuestionCondition;
  public QuestionType: QuestionType;
  public Question: string;
  public readonly Spacer: number = 10;
  public Answer: string;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Length = getShort(hex, 0x0);
    this.QuestionCondition = getByte(hex, 0x2) as QuestionCondition;
    this.QuestionType = getByte(hex, 0x3) as QuestionType;
    this.Question = getChar(hex, 0x4, this.QuestionLength());
    offset = 0x4 + this.QuestionLength();
    // static prop Spacer
    offset += 1;
    this.Answer = getChar(hex, offset, this.AnswerLength());
    offset += this.AnswerLength();
    this.PostMissionQuestionsLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Length: this.Length,
      QuestionCondition: this.QuestionConditionLabel,
      QuestionType: this.QuestionTypeLabel,
      Question: this.Question,
      Answer: this.Answer
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Length, 0x0);
    writeByte(hex, this.QuestionCondition, 0x2);
    writeByte(hex, this.QuestionType, 0x3);
    writeChar(hex, this.Question, 0x4, this.QuestionLength());
    writeByte(hex, 10, offset);
    offset += 1;
    writeChar(hex, this.Answer, offset, this.AnswerLength());
    offset += this.AnswerLength();

    return hex;
  }

  public get QuestionConditionLabel(): string {
    return Constants.QUESTIONCONDITION[this.QuestionCondition] || 'Unknown';
  }

  public get QuestionTypeLabel(): string {
    return Constants.QUESTIONTYPE[this.QuestionType] || 'Unknown';
  }
  protected abstract QuestionLength(): number;
  protected abstract AnswerLength(): number;
  public getLength(): number {
    return this.PostMissionQuestionsLength;
  }
}

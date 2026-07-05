import type { IMission } from '@pyrite/core';
import { PostMissionQuestionsBase } from './base/post-mission-questions-base';

export class PostMissionQuestions extends PostMissionQuestionsBase {
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    if (this.Length === 0) {
      this.PostMissionQuestionsLength = 2;
    }
  }

  protected QuestionLength(): number {
    if (this.Length === 0) {
      return 0;
    }
    let text: string = String.fromCodePoint(...new Uint8Array(this.hex.slice(4)));
    text = text.slice(0, Math.max(0, this.Length));
    const splitter = String.fromCodePoint(10);
    if (text.includes(splitter)) {
      const idx = text.indexOf(splitter);
      return idx;
    }
    console.warn('PostMissionQuestions: QuestionLength() - No splitter found in text:', text);
    return 0;
  }

  protected AnswerLength(): number {
    if (this.Length === 0) {
      return 0;
    }
    let text: string = String.fromCodePoint(...new Uint8Array(this.hex.slice(4)));
    text = text.slice(0, Math.max(0, this.Length));
    const splitter = String.fromCodePoint(10);
    if (text.includes(splitter)) {
      const idx = text.indexOf(splitter);
      return this.Length - idx - 3;
    }
    console.warn('PostMissionQuestions: AnswerLength() - No splitter found in text:', text);
    return 0;
  }
}

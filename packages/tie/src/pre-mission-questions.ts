import type { IMission } from '@pyrite/core';

import { PreMissionQuestionsBase } from './base/pre-mission-questions-base';

export enum QuestionType {
  Officer = 'Officer',
  Secret = 'Secret'
}

export class PreMissionQuestions extends PreMissionQuestionsBase {
  public Type?: QuestionType;

  public constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    if (this.Length === 0) {
      this.PreMissionQuestionsLength = 2;
    }
  }

  protected QuestionLength(): number {
    if (this.Length === 0) {
      return 0;
    }
    let text: string = String.fromCodePoint(...new Uint8Array(this.hex.slice(2)));
    text = text.slice(0, Math.max(0, this.Length));
    const splitter = String.fromCodePoint(10);
    if (text.includes(splitter)) {
      const idx = text.indexOf(splitter);
      return idx;
    }
    console.warn('PreMissionQuestions: QuestionLength() - No splitter found in text:', text);
    return 0;
  }

  protected AnswerLength(): number {
    if (this.Length === 0) {
      return 0;
    }
    let text: string = String.fromCodePoint(...new Uint8Array(this.hex.slice(2)));
    text = text.slice(0, Math.max(0, this.Length));
    const splitter = String.fromCodePoint(10);
    if (text.includes(splitter)) {
      const idx = text.indexOf(splitter);
      return this.Length - idx - 1;
    }
    console.warn('PreMissionQuestions: AnswerLength() - No splitter found in text:', text);
    return 0;
  }
}

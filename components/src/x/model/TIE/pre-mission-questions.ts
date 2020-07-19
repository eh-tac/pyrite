import { PreMissionQuestionsBase } from "./base/pre-mission-questions-base";
    
export class PreMissionQuestions extends PreMissionQuestionsBase {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected QuestionLength(): number {
    return 0;
  }
  protected AnswerLength(): number {
    return 0;
  }
}

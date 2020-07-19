import { PostMissionQuestionsBase } from "./base/post-mission-questions-base";
    
export class PostMissionQuestions extends PostMissionQuestionsBase {

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

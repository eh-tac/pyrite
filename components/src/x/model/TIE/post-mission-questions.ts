import { PostMissionQuestionsBase } from "./base/post-mission-questions-base";
    
    export class PostMissionQuestions extends PostMissionQuestionsBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
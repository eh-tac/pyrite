import { PreMissionQuestionsBase } from "./base/pre-mission-questions-base";
    
    export class PreMissionQuestions extends PreMissionQuestionsBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
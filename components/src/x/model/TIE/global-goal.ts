import { GlobalGoalBase } from "./base/global-goal-base";
    
    export class GlobalGoal extends GlobalGoalBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
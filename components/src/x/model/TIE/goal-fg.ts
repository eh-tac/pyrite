import { GoalFGBase } from "./base/goal-fg-base";
    
    export class GoalFG extends GoalFGBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
import { MissionBase } from "./base/mission-base";
    
    export class Mission extends MissionBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
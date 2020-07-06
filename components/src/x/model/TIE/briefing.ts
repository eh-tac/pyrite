import { BriefingBase } from "./base/briefing-base";
    
    export class Briefing extends BriefingBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
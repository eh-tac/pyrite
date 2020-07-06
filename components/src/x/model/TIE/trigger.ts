import { TriggerBase } from "./base/trigger-base";
    
    export class Trigger extends TriggerBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
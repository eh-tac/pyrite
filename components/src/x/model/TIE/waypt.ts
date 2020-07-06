import { WayptBase } from "./base/waypt-base";
    
    export class Waypt extends WayptBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
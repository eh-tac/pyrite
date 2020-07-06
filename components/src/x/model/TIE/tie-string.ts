import { TIEStringBase } from "./base/tie-string-base";
    
    export class TIEString extends TIEStringBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
import { FlightGroupBase } from "./base/flight-group-base";
    
    export class FlightGroup extends FlightGroupBase {
      constructor(hex: ArrayBuffer, tie?: Mission) {
        super(hex, tie);
      }

      public beforeConstruct(): void {}

      // TODO abstract stubs?
    }
    
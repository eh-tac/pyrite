import { Constants } from ".";
import { FlightGroupBase } from "./base/flight-group-base";

export class FlightGroup extends FlightGroupBase {
  public beforeConstruct(): void {}

  public get CraftTypeAbbr(): string {
    return Constants.CRAFTABBR[this.CraftType];
  }

  public toString(): string {
    return `${this.CraftTypeAbbr} ${this.Name}`;
  }
}

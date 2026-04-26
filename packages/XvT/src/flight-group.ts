import { FlightGroupBase } from "./base/flight-group-base";
import { Constants } from "./constants";

export class FlightGroup extends FlightGroupBase {
  public beforeConstruct(): void {}

  public get label(): string {
    return this.toString();
  }

  public get CraftTypeAbbr(): string {
    return Constants.SHIPS[this.CraftType];
  }

  public toString(): string {
    return `${this.CraftTypeAbbr} ${this.Name}`;
  }

  public validate(): void {
    if (this.GroupAILabel === "Unknown") {
      console.warn(`${this} has unknown AI ${this.GroupAI}`);
    } else {
      // console.log(`${this.label} ${this.GroupAI}`);
    }
  }
}

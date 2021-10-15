import { FlightGroupBase } from "./base/flight-group-base";

export class FlightGroup extends FlightGroupBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return [
      `[${this.IFFLabel}]`,
      `${this.NumberOfWaves + 1}x${this.NumberOfCraft}`,
      this.CraftTypeLabel,
      this.Name,
      this.CraftObjective ? ` - MUST ${this.CraftObjectiveLabel}` : ""
    ].join(" ");
  }
}

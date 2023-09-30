import { FlightGroupBase } from "./base/flight-group-base";
import { ArrivalEvent } from "./constants";

export class FlightGroup extends FlightGroupBase {
  public beforeConstruct(): void {}

  public get presentAtStart(): boolean {
    return this.ArrivalEvent === ArrivalEvent.missionStart && this.ArrivalDelay === 0;
  }

  public get arrivalLabel(): string {
    const delay = this.ArrivalDelay ? `${this.arrivalDelaySeconds} sec after` : "";
    const trigger = this.ArrivalFG > 0 ? this.TIE.FlightGroups[this.ArrivalFG]?.label : "";
    const event = this.ArrivalEventLabel.replace("On ", "");
    return `...${delay} ${trigger} ${event}`.trim();
  }

  public get arrivalDelaySeconds(): number {
    const ad = this.ArrivalDelay;
    if (ad <= 20) {
      return ad * 60; // 0-20 is in minutes.
    } else {
      return (ad - 20) * 6;
    }
  }

  public get CraftTypeLabelAbbr(): string {
    const abbr = {
      0: "UNK",
      1: "XW",
      2: "YW",
      3: "AW",
      4: "T/F",
      5: "T/I",
      6: "T/B",
      7: "GUN",
      8: "TRN",
      9: "SHU",
      10: "TUG",
      11: "CN",
      12: "FRT",
      13: "CRS",
      14: "FRG",
      15: "CRV",
      16: "ISD",
      17: "T/A",
      18: "B/W"
    };
    return abbr[this.CraftType];
  }

  public get label(): string {
    return `${this.CraftTypeLabelAbbr} ${this.Name}`;
  }

  public toString(): string {
    const arrival = this.presentAtStart ? "" : this.arrivalLabel;
    return [
      `[${this.IFFLabel}]`,
      `${this.NumberOfWaves + 1}x${this.NumberOfCraft}`,
      this.CraftTypeLabel,
      this.Name,
      this.Objective ? ` - MUST ${this.ObjectiveLabel}` : "",
      this.Objective ? arrival : ""
    ].join(" ");
  }
}

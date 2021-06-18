import { IFlightGroup, IMission } from "../pyrite-base";
import { MissionBase } from "./base/mission-base";

export class Mission extends MissionBase implements IMission {
  getFlightGroup(idx: number): IFlightGroup {
    throw new Error("Method not implemented.");
  }
  getGlobalGroup(idx: number): IFlightGroup[] {
    throw new Error("Method not implemented.");
  }
  getIFF(idx: number): string {
    throw new Error("Method not implemented.");
  }
  public beforeConstruct(): void {
    this.TIE = this;
  }

  public toString(): string {
    return "";
  }

  public validate(): void {
    this.FlightGroups.forEach(fg => {
      fg.validate();
    });
  }

  protected FGGoalStringCount(): number {
    return this.FileHeader.NumFGs * 24;
  }
}

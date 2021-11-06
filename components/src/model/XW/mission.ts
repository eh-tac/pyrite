import { MissionBase } from "./base/mission-base";

export class Mission extends MissionBase {
  public beforeConstruct(): void {
    this.TIE = this as any;
  }

  public toString(): string {
    return "";
  }
}

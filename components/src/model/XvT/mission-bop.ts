import { MissionBOPBase } from "./base/mission-bop-base";

export class MissionBOP extends MissionBOPBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  protected FGGoalStringCount(): number {
    return 0;
  }
}

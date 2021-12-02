import { MissionBase } from "./base/mission-base";
    
export class Mission extends MissionBase {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected FGGoalStringCount(): number {
    return 0;
  }
}

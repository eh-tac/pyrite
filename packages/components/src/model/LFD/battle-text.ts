import { BattleTextBase } from "./base/battle-text-base";

export class BattleText extends BattleTextBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  protected NumMissions(): number {
    return this.MissionFiles.Substrings.length;
  }
}

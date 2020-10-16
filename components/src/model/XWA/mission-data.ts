import { MissionScore } from "../pilot";
import { MissionDataBase } from "./base/mission-data-base";

export class MissionData extends MissionDataBase implements MissionScore {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public get Total(): number {
    return this.Score + this.BonusScoreTen / 10;
  }

  public get scoreLabel(): string {
    return `${this.Total}`;
  }

  public get timeLabel(): string {
    if (!this.Time) {
      return "";
    }
    const min = Math.floor(this.Time / 60);
    const sec = this.Time % 60;
    return `${min}:${sec < 10 ? "0" + sec : sec} min`;
  }

  public get score(): number {
    return this.Total;
  }

  public get completed(): boolean {
    return !!this.WinCount;
  }
}

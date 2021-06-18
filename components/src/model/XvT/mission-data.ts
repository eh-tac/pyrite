import { MissionDataBase } from "./base/mission-data-base";

export class MissionData extends MissionDataBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public get unlimited(): boolean {
    return this.WinCount > 0 && this.BestScore === 0 && this.BestTime === 0;
  }

  public get summary(): string {
    const complete = this.WinCount > 0;
    if (this.unlimited) {
      return `Completed with unlimited waves`;
    } else if (complete) {
      return `${this.BestScore} - ${this.BestTime}:${this.BestTimeSecond} (${this.BestRatingLabel})`;
    } else {
      return `Mission not completed`;
    }
  }

  public get scoreLabel(): string {
    return this.unlimited ? "Unlimited waves (0)" : `${this.BestScore}`;
  }

  public get timeLabel(): string {
    if (!this.BestTime) {
      return "";
    }
    const min = Math.floor(this.BestTime / 60);
    const sec = this.BestTime % 60;
    return `${min}:${sec < 10 ? "0" + sec : sec} min`;
  }
}

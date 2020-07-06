import { MissionResult } from "./mission-result";

export class XWAMission implements MissionResult {
  constructor(
    public attempts: number,
    public completed: number,
    public score: number,
    public time: number,
    public bonusTen: number
  ) {}

  public get total(): number {
    return this.score + this.bonus;
  }

  public get bonus(): number {
    return this.bonusTen / 10;
  }

  public get scoreLabel(): string {
    return `${this.total}`;
  }

  public get timeLabel(): string {
    if (!this.time) {
      return "";
    }
    const min = Math.floor(this.time / 60);
    const sec = this.time % 60;
    return `${min}:${sec < 10 ? "0" + sec : sec} min`;
  }
}

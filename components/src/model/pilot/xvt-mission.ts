import { MissionResult } from "./mission-result";

const medals = ["Gold", "Silver", "Bronze", "Nickel", "Copper", "Lead"];

export class XvTMission implements MissionResult {
  constructor(
    public attempts: number,
    public wins: number,
    public losses: number,
    public bestScore: number,
    public bestTime: number,
    public bestTimeToo: number,
    public bestRating: number,
    public something: number,
    public other: number
  ) {}

  public get rating(): string {
    return medals[this.bestRating] || "";
  }

  public get unlimited(): boolean {
    return this.wins > 0 && this.bestScore === 0 && this.bestTime === 0;
  }

  public get summary(): string {
    const complete = this.wins > 0;
    if (this.unlimited) {
      return `Completed with unlimited waves`;
    } else if (complete) {
      return `${this.bestScore} - ${this.bestTime}:${this.bestTimeToo} (${this.rating})`;
    } else {
      return `Mission not completed`;
    }
  }

  public get scoreLabel(): string {
    return this.unlimited ? "Unlimited waves (0)" : `${this.bestScore}`;
  }

  public get timeLabel(): string {
    if (!this.bestTime) {
      return "";
    }
    const min = Math.floor(this.bestTime / 60);
    const sec = this.bestTime % 60;
    return `${min}:${sec < 10 ? "0" + sec : sec} min`;
  }
}

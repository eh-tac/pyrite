import { PL2CampaignRecordBase } from "./base/pl-2-campaign-record-base";

export class PL2CampaignRecord extends PL2CampaignRecordBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public get unlimited(): boolean {
    return this.isMissionComplete > 0 && this.bestScore === 0 && this.bestTimeAsSeconds === 0;
  }

  public get scoreLabel(): string {
    return this.unlimited ? "Unlimited waves (0)" : `${this.bestScore}`;
  }

  public get timeLabel(): string {
    if (!this.bestTimeAsSeconds) {
      return "";
    }
    const min = Math.floor(this.bestTimeAsSeconds / 60);
    const sec = `${this.bestTimeAsSeconds % 60}`.padStart(2, "0");
    return `${min}:${sec} min`;
  }
}

import { PL2FileRecordBase } from "./base/pl-2-file-record-base";
import { PL2CampaignRecord } from "./pl-2-campaign-record";
import { PL2FactionRecord } from "./pl-2-faction-record";

export class PL2FileRecord extends PL2FileRecordBase {
  public beforeConstruct(): void {}

  public getCompletedMissions(isCampaign = false): PL2CampaignRecord[] {
    if (!isCampaign) {
      return []; // PL2 files are only used for campaign submissions
    }
    // the first 15 we want are offsets 51-65 in the imperial faction's campaign record
    const imperial = this.getImperialFaction().missionSPCampaign.slice(51, 66);
    // the next 15 we want are offsets 71-85 in the rebel faction's campaign record
    const rebel = this.getRebelFaction().missionSPCampaign.slice(71, 86);
    const combined = [...imperial, ...rebel];
    return combined.filter((mission: PL2CampaignRecord) => {
      return mission.isMissionComplete === 1;
    });
  }

  public getRebelFaction(): PL2FactionRecord {
    return this.faction[0];
  }

  public getImperialFaction(): PL2FactionRecord {
    return this.faction[1];
  }

  public getCompletedMissionScores(isCampaign = false): number[] {
    return this.getCompletedMissions(isCampaign).map((mission: PL2CampaignRecord) => {
      return mission.bestScore;
    });
  }

  public getCompletedMissionTimes(isCampaign = false): number[] {
    return this.getCompletedMissions(isCampaign).map((mission: PL2CampaignRecord) => {
      return mission.bestTimeAsSeconds;
    });
  }

  public getLasersFired(): any {
    return this.totalLaserFired.exercise;
  }

  public getLasersHit(): any {
    return this.totalLaserHit.exercise;
  }

  public getWarheadsFired(): any {
    return this.totalWarheadFired.exercise;
  }

  public getWarheadsHit(): any {
    return this.totalWarheadHit.exercise;
  }

  public getKills(): any {
    return this.totalKillCount.exercise;
  }

  public get LaserLabel(): string {
    return this.shootInfo(this.getLasersHit(), this.getLasersFired());
  }

  public get LaserPercent(): string {
    return this.percent(this.getLasersHit(), this.getLasersFired());
  }

  public get WarheadLabel(): string {
    return this.shootInfo(this.getWarheadsHit(), this.getWarheadsFired());
  }

  public get WarheadPercent(): string {
    return this.percent(this.getWarheadsHit(), this.getWarheadsFired());
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit.toLocaleString()} / ${fired.toLocaleString()}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }
}

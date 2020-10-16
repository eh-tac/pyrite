import { BattleSummary, MissionScore } from "../pilot";
import { MissionData } from "../XvT";
import { PilotFileBase } from "./base/pilot-file-base";
import { Constants } from "./constants";

export interface TriStat {
  Label: string;
  TourOfDuty: string | number;
  Azzameen: string | number;
  Simulator: string | number;
}

const BaseMissionCounts: number[] = [9, 7, 6, 7, 6, 7, 7, 4];

export class PilotFile extends PilotFileBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public get BonusScore(): number {
    return this.BonusTen / 10;
  }

  public get LaserLabel(): string {
    return this.shootInfo(this.LasersHit, this.LasersFired);
  }

  public get LaserPercent(): string {
    return this.percent(this.LasersHit, this.LasersFired);
  }

  public get WarheadLabel(): string {
    return this.shootInfo(this.WarheadsHit, this.WarheadsFired);
  }

  public get WarheadPercent(): string {
    return this.percent(this.WarheadsHit, this.WarheadsFired);
  }

  public get BattleSummary(): BattleSummary[] {
    const battles: BattleSummary[] = [];
    let m = 0;
    for (const mCount of BaseMissionCounts) {
      console.log(m);
      const missions = this.MissionData.slice(m, m + mCount);
      const won = missions.filter(m => m.WinCount && m.AttemptCount).length;
      const completed = won === mCount;
      let status = "None";
      if (completed) {
        status = "Completed";
      } else if (won) {
        status = "Incomplete";
      }
      battles.push({ completed, status, missions });
      m += mCount;
    }
    let status = "None";
    let completed = false;
    let missions: MissionScore[] = [];
    while (this.MissionData[m].AttemptCount) {
      const mis = this.MissionData[m];
      completed = true;
      status = "Completed";
      missions.push(mis);
      m++;
    }
    battles.push({ completed, status, missions });
    for (let i = 0; i < 255; i++) {
      if (this.MissionData[i] && this.MissionData[i].WinCount) {
        console.log(i, "mission i", this.MissionData[i]);
      }
    }

    return battles;
  }

  public get BattleVictories(): TriStat[] {
    const victories: TriStat[] = [];
    for (let i = 1; i < this.TourOfDutyKills.length; i++) {
      if (this.hasTypeKills(i)) {
        victories.push({
          Label: Constants.CRAFTTYPE[i],
          TourOfDuty: `${this.TourOfDutyKills[i]} (${this.TourOfDutyPartials[i]})`,
          Azzameen: `${this.AzzameenKills[i]} (${this.AzzameenPartials[i]})`,
          Simulator: `${this.SimulatorKills[i]} (${this.SimulatorPartials[i]})`
        });
      }
    }
    return victories;
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit} / ${fired}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }

  private hasTypeKills(type: number): boolean {
    const k: number =
      this.TourOfDutyKills[type] ||
      this.TourOfDutyPartials[type] ||
      this.AzzameenKills[type] ||
      this.AzzameenPartials[type] ||
      this.SimulatorKills[type] ||
      this.SimulatorPartials[type];
    return k > 0;
  }
}

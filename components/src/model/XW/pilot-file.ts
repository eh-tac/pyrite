import { PilotFileBase } from "./base/pilot-file-base";
import { PilotData, MissionScore, BattleSummary, KillSummary } from "../pilot";
import { Constants, TourStatus } from "./constants";

export class PilotFile extends PilotFileBase implements PilotData {
  public get LaserLabel(): string {
    return this.shootInfo(this.LaserCraftHits + this.LaserGroundHits, this.LasersFired);
  }

  public get LaserPercent(): string {
    return this.percent(this.LaserCraftHits + this.LaserGroundHits, this.LasersFired);
  }

  public get WarheadLabel(): string {
    return this.shootInfo(this.MissileCraftHits + this.MissileGroundHits, this.MissilesFired);
  }

  public get WarheadPercent(): string {
    return this.percent(this.MissileCraftHits + this.MissileGroundHits, this.MissilesFired);
  }

  public get BattleSummary(): BattleSummary[] {
    const tods = [this.Tour1Scores, this.Tour2Scores, this.Tour3Scores, this.Tour4Scores, this.Tour5Scores];

    return tods.map((scores: number[], battle: number) => {
      const status = this.TourStatus[battle];
      const last = this.TourOperationsComplete[battle];
      const bs: BattleSummary = {
        completed: status === TourStatus.complete,
        status: Constants.TOURSTATUS[this.TourStatus[battle]],
        missions: scores.slice(0, last || 0).map((score: number, m: number) => {
          return {
            completed: true,
            score
          };
        })
      };
      return bs;
    });
  }

  public get MissionScores(): MissionScore[] {
    return this.BattleSummary.reduce(
      (carry: MissionScore[], battle: BattleSummary) => carry.concat(battle.missions),
      []
    );
  }

  public get BattleVictories(): KillSummary[] {
    return this.TODKills.map(
      (kills: number, i: number): KillSummary => {
        const craftLabel = Constants.SHIPTYPE[i + 1];
        return {
          craftLabel,
          kills
        };
      }
    );
  }

  public get TrainingSummary(): TrainingSummary[] {
    const craft = ["X-Wing", "Y-Wing", "A-Wing", "B-Wing"];
    const hisCom = [
      this.XWingHistoricalComplete,
      this.YWingHistoricalComplete,
      this.AWingHistoricalComplete,
      this.BWingHistoricalComplete
    ];
    const hisScore = [
      this.XWingHistoricalScore,
      this.YWingHistoricalScore,
      this.AWingHistoricalScore,
      this.BWingHistoricalScore
    ];
    return craft.map((craftLabel: string, idx: number) => {
      const summary: TrainingSummary = {
        craftLabel,
        scoreLabel: "Not flown",
        trainingLevel: this.MazeLevel[idx],
        trainingScore: this.MazeScore[idx],
        missions: hisCom[idx].map((complete: boolean, mission: number) => {
          const combatMission: MissionScore = {
            completed: complete,
            score: hisScore[idx][mission]
          };
          return combatMission;
        })
      };
      if (summary.trainingScore) {
        summary.scoreLabel = `${summary.trainingScore} (Level ${summary.trainingLevel})`;
      }

      return summary;
    });
  }

  public get TotalXWHistoricScore(): number {
    return this.XWingHistoricalScore.reduce((a, b) => a + b, 0);
  }

  public get XWingHistoricalMissions(): MissionScore[] {
    return this.XWingHistoricalScore.map((score, index) => {
      return {
        completed: this.XWingHistoricalComplete[index],
        score
      };
    });
  }

  public get TotalKills(): number {
    return this.TODKills.reduce((a, b) => a + b, 0);
  }

  public get TotalCaptures(): number {
    return this.TODCaptures.reduce((a, b) => a + b, 0);
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit.toLocaleString()} / ${fired.toLocaleString()}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }
}

export interface TrainingSummary {
  craftLabel: string;
  scoreLabel: string;
  trainingLevel: number;
  trainingScore: number;
  missions: MissionScore[];
}

import { PilotFileBase } from "./base/pilot-file-base";
import { BattleSummary, PilotData, shootInfo, percent, KillSummary, MissionScore, TrainingSummary } from "../pilot";
import { getByteString } from "../../hex";
import { Constants, BattleStatus } from "./constants";
import * as lodash from "lodash";

export class PilotFile extends PilotFileBase implements PilotData {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public get LaserlessScore(): number {
    return this.Score - this.LasersHit * 3;
  }

  public get LaserLabel(): string {
    return shootInfo(this.LasersHit, this.LasersFired);
  }

  public get LaserPercent(): string {
    return percent(this.LasersHit, this.LasersFired);
  }

  public get WarheadLabel(): string {
    return shootInfo(this.WarheadsHit, this.WarheadsFired);
  }

  public get WarheadPercent(): string {
    return percent(this.WarheadsHit, this.WarheadsFired);
  }

  public get BattleSummary(): BattleSummary[] {
    const battles = lodash.chunk(this.BattleScores, 8);
    return battles.map((scores: number[], battle: number) => {
      const status = this.BattleStatuses[battle];
      const last = this.BattleLastMissions[battle];
      const secret = getByteString(this.SecretObjectives[battle]);
      const bonus = getByteString(this.BonusObjectives[battle]);
      const bs: BattleSummary = {
        completed: status === BattleStatus.completed,
        status: Constants.BATTLESTATUS[status],
        missions: scores.slice(0, last || 0).map((score: number, m: number) => {
          const mission: MissionScore = {
            completed: true,
            score,
            secret: secret.charAt(m) === "1",
            bonus: bonus.charAt(m) === "1"
          };
          return mission;
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
    return this.KillsByType.map((kills: number, i: number) => {
      const craftLabel = Constants.CRAFTTYPE[i + 1];
      return {
        craftLabel,
        kills
      } as KillSummary;
    });
  }

  public get TrainingSummary(): TrainingSummary[] {
    const combatCompletions = lodash.chunk(this.CombatCompletes, 8);
    return Object.values(Constants.TRAININGCRAFT).map((craft: string, idx: number) => {
      const summary: TrainingSummary = {
        craftLabel: craft,
        scoreLabel: "Not flown",
        trainingLevel: this.TrainingLevels[idx],
        trainingScore: this.TrainingScores[idx],
        missions: combatCompletions[idx].map((complete: boolean, mission: number) => {
          const combatMission: MissionScore = {
            completed: complete,
            score: this.CombatScores[idx][mission]
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
}

import { accuracy, percent } from '@pyrite/core';
import { TeamStatsBase } from './base/team-stats-base';
import { Constants, Ships } from './constants';

export interface TriStat {
  Label: string;
  Exercise: string | number;
  Melee: string | number;
  Combat: string | number;
}

export class TeamStats extends TeamStatsBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }
  public hasData(): boolean {
    return this.PlayCounts.some((n) => !!n);
  }

  public get BattleVictories(): TriStat[] {
    const victories: TriStat[] = [];
    for (let i = 1; i < this.ExerciseKillsByType.length; i++) {
      if (this.hasTypeKills(i)) {
        victories.push({
          Label: Constants.SHIPS[i as Ships],
          Exercise: `${this.ExerciseKillsByType[i]} (${this.ExercisePartialsByType[i]})`,
          Melee: `${this.MeleeKillsByType[i]} (${this.MeleePartialsByType[i]})`,
          Combat: `${this.CombatKillsByType[i]} (${this.CombatAssistsByType[i]})`
        });
      }
    }
    return victories;
  }

  public get LaserLabel(): TriStat {
    return {
      Label: 'Lasers',
      Exercise: accuracy(this.LasersHit[0], this.LasersTotal[0]),
      Melee: accuracy(this.LasersHit[1], this.LasersTotal[1]),
      Combat: accuracy(this.LasersHit[2], this.LasersTotal[2])
    };
  }

  public get LaserPercent(): TriStat {
    return {
      Label: '',
      Exercise: percent(this.LasersHit[0], this.LasersTotal[0]),
      Melee: percent(this.LasersHit[1], this.LasersTotal[1]),
      Combat: percent(this.LasersHit[2], this.LasersTotal[2])
    };
  }

  public get WarheadLabel(): TriStat {
    return {
      Label: 'Warheads',
      Exercise: accuracy(this.WarheadsHit[0], this.WarheadsTotal[0]),
      Melee: accuracy(this.WarheadsHit[1], this.WarheadsTotal[1]),
      Combat: accuracy(this.WarheadsHit[2], this.WarheadsTotal[2])
    };
  }

  public get WarheadPercent(): TriStat {
    return {
      Label: '',
      Exercise: percent(this.WarheadsHit[0], this.WarheadsTotal[0]),
      Melee: percent(this.WarheadsHit[1], this.WarheadsTotal[1]),
      Combat: percent(this.WarheadsHit[2], this.WarheadsTotal[2])
    };
  }

  public get MissionsFlown(): TriStat {
    return {
      Label: 'Missions Flown',
      Exercise: this.PlayCounts[0],
      Melee: this.PlayCounts[1],
      Combat: this.PlayCounts[2]
    };
  }

  public get Kills(): TriStat {
    return {
      Label: 'Kills',
      Exercise: this.totalKills[0],
      Melee: this.totalKills[1],
      Combat: this.totalKills[2]
    };
  }

  public get HiddenCargo(): TriStat {
    return {
      Label: 'Hidden Cargo Found',
      Exercise: this.HiddenCargoFound[0],
      Melee: this.HiddenCargoFound[1],
      Combat: this.HiddenCargoFound[2]
    };
  }

  public get CraftLostStat(): TriStat {
    return {
      Label: 'Craft Lost',
      Exercise: this.CraftLosses[0],
      Melee: this.CraftLosses[1],
      Combat: this.CraftLosses[2]
    };
  }

  public get Collisions(): TriStat {
    return {
      Label: 'Collisions',
      Exercise: this.CollisionLosses[0],
      Melee: this.CollisionLosses[1],
      Combat: this.CollisionLosses[2]
    };
  }

  private hasTypeKills(type: number): boolean {
    const k: number =
      this.ExerciseKillsByType[type] ||
      this.ExercisePartialsByType[type] ||
      this.MeleeKillsByType[type] ||
      this.MeleePartialsByType[type] ||
      this.CombatKillsByType[type] ||
      this.CombatPartialsByType[type];
    return k > 0;
  }
}

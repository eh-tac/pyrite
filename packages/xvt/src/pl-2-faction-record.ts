import { IMission } from '@pyrite/core';
import { PL2FactionRecordBase } from './base/pl-2-faction-record-base';
import { Constants, Ships } from './constants';
import { TriStat } from './team-stats';

export class PL2FactionRecord extends PL2FactionRecordBase {
  public beforeConstruct(): void {}

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE);
    this.totalFlownSeries.Label = 'Missions Flown';
    this.totalLaserFired.Label = 'Lasers Fired';
    this.totalLaserHit.Label = 'Lasers Hit';
    this.totalWarheadFired.Label = 'Warheads Fired';
    this.totalWarheadHit.Label = 'Warheads Hit';
    this.totalFullKills.Label = 'Kills';
    this.totalHiddenCargoFound.Label = 'Hidden Cargo Found';
    this.totalLosses.Label = 'Craft Losses';
    this.totalLossesByCollision.Label = 'Collisions';
  }

  public toString(): string {
    return '';
  }

  public hasData(): boolean {
    return this.missionSPCampaign.some((mission: any) => {
      return mission.isMissionComplete === 1;
    });
  }

  public get BattleVictories(): TriStat[] {
    const victories: TriStat[] = [];
    for (let i = 1; i < 93; i++) {
      if (this.hasTypeKills(i)) {
        victories.push({
          Label: Constants.SHIPS[i as Ships],
          Exercise: `${this.totalFullKillsOnCraftEMC[i]} (${this.totalSharedKillsOnCraftEMC[i]})`,
          Melee: `${this.totalFullKillsOnCraftEMC[i + 100]} (${this.totalSharedKillsOnCraftEMC[i + 100]})`,
          Combat: `${this.totalFullKillsOnCraftEMC[i + 200]} (${this.totalSharedKillsOnCraftEMC[i + 200]})`
        });
      }
    }
    return victories;
  }

  private hasTypeKills(type: number): boolean {
    const k: number =
      this.totalFullKillsOnCraftEMC[type] ||
      this.totalSharedKillsOnCraftEMC[type] ||
      this.totalFullKillsOnCraftEMC[type + 100] ||
      this.totalSharedKillsOnCraftEMC[type + 100] ||
      this.totalFullKillsOnCraftEMC[type + 200] ||
      this.totalSharedKillsOnCraftEMC[type + 200];
    return k > 0;
  }
}

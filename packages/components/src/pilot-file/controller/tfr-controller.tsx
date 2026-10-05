import type { BattleSummary, KillSummary, MissionScore, TrainingSummary } from '@pyrite/core';
import type { BattleDetail } from '@pyrite/ehtc-api';
import type { PilotFile } from '@pyrite/tie';
import type { JSX } from '@stencil/core/jsx-runtime';

import { MaterialIcon } from '../../material-icon/material-icon';
import { PilotFileController } from './controller';

export class TFRController extends PilotFileController {
  public constructor(
    filepath: string,
    public tfr: PilotFile,
  ) {
    super(filepath);
  }

  public renderTabs(battleData?: BattleDetail): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [
      ['Summary', this.renderPilotInformation()],
      ['Battles', this.renderBattles()],
      ['Kills', this.renderKills()],
      ['Training', this.renderTraining()],
    ];

    if (battleData) {
      tabs.unshift(['BSF', this.renderBSF(battleData)]);
    }
    return tabs;
  }

  private renderBSF(battleData: BattleDetail): JSX.Element {
    const scores = battleData.highScores;

    const totalScore: number = this.tfr.LaserlessScore;
    const percent: string =
      scores && scores.total && scores.total.score
        ? this.percentage(totalScore, scores.total.score)
        : 'No high score found';
    const type = battleData.missions === 1 ? 'Mission' : 'Battle';

    const battleRow = (
      <li class="list-group-item kv heading d-flex justify-content-between">
        <div class="d-flex flex-column">
          <h6 class="my-0">{type} Score</h6>
          <small class="text-muted"> (laserless)</small>
        </div>
        <div class="d-flex flex-column">
          <span class="text-info font-weight-bold">{totalScore}</span>
          <small class="text-light text-right">{percent}</small>
        </div>
      </li>
    );

    const missionScores = this.tfr.MissionScores;
    const mCount = Math.max(missionScores.length, scores?.missions?.length ?? 0);
    const missions = [];
    for (let m = 0; m < mCount; m++) {
      if (missionScores[m] && scores?.missions?.[m]) {
        missions.push(this.renderTIEMission(`Mission ${m + 1}`, missionScores[m], scores.missions[m].score));
      } else if (missionScores[m]) {
        missions.push(
          this.renderItem(`Mission ${m + 1}`, missionScores[m].score, 'Too many missionss flown', 'text-danger'),
        );
      } else if (scores?.missions?.[m]) {
        missions.push(this.renderItem(`Mission ${m + 1}`, 'Not flown', '', 'text-danger'));
      } else {
        console.error('Unknown state?');
      }
    }

    return (
      <ul class="list-group">
        <li class="list-group-item heading">BSF Details</li>
        {this.renderItem('Filename', this.filename)}
        {this.renderItem('Lasers', this.tfr.LaserLabel, this.tfr.LaserPercent)}
        {this.renderItem('Warheads', this.tfr.WarheadLabel, this.tfr.WarheadPercent)}
        {this.renderItem('Kills', this.tfr.TotalKills)}
        {this.renderItem('Captures', this.tfr.TotalCaptures)}

        {battleRow}
        {missions}
      </ul>
    );
  }

  private renderTIEMission(key: string, mission: MissionScore, highScore?: number): JSX.Element {
    const score = mission.score || 0;
    const complete = mission.completed;
    const secret = mission.secret;
    const bonus = mission.bonus;
    const hs = highScore ? this.percentage(mission.score, highScore) : '';

    if (!complete && !score) {
      return null;
    }
    console.log('render tie mission', key, mission, score);
    // TODO get icons rendering with styles
    const icons: JSX.Element[] = [
      complete ? (
        <span class="complete">
          <MaterialIcon name="check" />
        </span>
      ) : (
        <span class="incomplete">
          <MaterialIcon name="check_indeterminate_small" />
        </span>
      ),
    ];
    if (secret) {
      icons.push(
        <span class="secret">
          <MaterialIcon name="award_star" />
        </span>,
      );
    }
    if (bonus) {
      icons.push(
        <span class="bonus">
          <MaterialIcon name="award_star" />
        </span>,
      );
    }

    return (
      <div class="list-group-item data d-flex justify-content-between">
        <h6 class="">{key}</h6>
        <div class="d-flex flex-column">
          <span class="d-inline text-info text-right">{score?.toLocaleString()}</span>
          <small class="text-light text-right">{hs}</small>
        </div>
      </div>
    );
  }

  private renderPilotInformation(): JSX.Element {
    const fields: { [key: string]: string | number } = {
      'Filename': this.filename,
      'Difficulty': this.tfr.PilotDifficultyLabel,
      'Status': this.tfr.PilotStatusLabel,
      'Rank': this.tfr.PilotRankLabel,
      'Secret Order': this.tfr.SecretOrderLabel,
      'Score': this.tfr.Score.toLocaleString(),
      'Skill': this.tfr.SkillScore === -1 ? 'Maximum' : this.tfr.SkillScore.toLocaleString(),
      'Laser hits': this.tfr.LaserLabel,
      'Warhead hits': this.tfr.WarheadLabel,
      'Kills': this.tfr.TotalKills.toLocaleString(),
      'Captures': this.tfr.TotalCaptures.toLocaleString(),
      'Craft lost': this.tfr.CraftLost.toLocaleString(),
    };

    return (
      <ul class="list-group">
        <li class="list-group-item heading">Pilot Information</li>
        {Object.entries(fields).map((value: [string, string | number]) => this.renderItem(value[0], value[1]))}
      </ul>
    );
  }

  private renderBattles(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Tours of Duty</li>
        {this.tfr.BattleSummary.map(
          (battle: BattleSummary, b: number) =>
            battle.missions.length > 0 && (
              <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1 text-muted">Battle {b + 1}</h5>
                  <small>{battle.status}</small>
                </div>
                {battle.missions.map((mission: MissionScore, m: number) =>
                  this.renderTIEMission(`Mission ${m + 1}`, mission),
                )}
              </li>
            ),
        )}
      </ul>
    );
  }

  private renderKills(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Player Battle Victories</li>
        {this.tfr.BattleVictories.filter((bv: KillSummary) => bv.kills).map((bv: KillSummary) =>
          this.renderItem(bv.craftLabel, bv.kills),
        )}
        <li class="list-group-item no-data">
          <small class="text-muted">No kills recorded</small>
        </li>
      </ul>
    );
  }

  private renderTraining(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Obstacle Courses and Missions</li>
        {this.tfr.TrainingSummary.map((train: TrainingSummary) => (
          <li class="list-group-item">
            <h5 class="mb-1">{train.craftLabel}</h5>
            {this.renderItem('Obstacle Course', train.scoreLabel, '', 'py-0')}
            {train.missions.map((mission: MissionScore, m: number) =>
              this.renderTIEMission(`Mission ${m + 1}`, mission),
            )}
            <li class="list-group-item no-data py-0">
              <span class="text-muted">No training missions flown</span>
            </li>
          </li>
        ))}
      </ul>
    );
  }
}

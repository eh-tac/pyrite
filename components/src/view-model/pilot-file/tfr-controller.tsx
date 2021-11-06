import { JSX, h } from "@stencil/core";

import { PilotFileController } from "./controller";
import { TrainingSummary, MissionScore, KillSummary, BattleSummary } from "../../model/pilot";
import { Battle } from "../../model/ehtc";
import { PilotFile } from "../../model/TIE";

export class TFRController extends PilotFileController {
  public constructor(filepath: string, public tfr: PilotFile) {
    super(filepath);
  }

  public renderTabs(battleData?: Battle): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [
      ["Summary", this.renderPilotInformation()],
      ["Battles", this.renderBattles()],
      ["Kills", this.renderKills()],
      ["Training", this.renderTraining()]
    ];

    if (battleData) {
      tabs.unshift(["BSF", this.renderBSF(battleData)]);
    }
    return tabs;
  }

  private renderBSF(battleData: Battle): JSX.Element {
    const scores = battleData.highScores;

    const totalScore: number = this.tfr.LaserlessScore;
    const percent: string =
      scores && scores.total ? this.percentage(totalScore, scores.total.score) : "No high score found";
    const type = battleData.missions === 1 ? "Mission" : "Battle";

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
    const mCount = Math.max(missionScores.length, scores.missions.length);
    const missions: JSX.Element[] = [];
    missionScores.unshift(missionScores[0]); // make it 1 indexed basically.
    for (let m = 1; m <= mCount; m++) {
      if (missionScores[m] && scores[m]) {
        missions.push(this.renderTIEMission(`Mission ${m}`, missionScores[m], scores[m].score));
      } else if (missionScores[m]) {
        missions.push(
          this.renderItem(`Mission ${m}`, missionScores[m].score),
          "Too many missions flown",
          "text-danger"
        );
      } else if (scores[m]) {
        missions.push(this.renderItem(`Mission ${m}`, "Not flown", "", "text-danger"));
      } else {
        console.error("Unknown state?");
      }
    }

    return (
      <ul class="list-group">
        <li class="list-group-item heading">BSF Details</li>
        {this.renderItem("Filename", this.filename)}
        {this.renderItem("Lasers", this.tfr.LaserLabel, this.tfr.LaserPercent)}
        {this.renderItem("Warheads", this.tfr.WarheadLabel, this.tfr.WarheadPercent)}
        {this.renderItem("Kills", this.tfr.TotalKills)}
        {this.renderItem("Captures", this.tfr.TotalCaptures)}

        {battleRow}
        {missions}
      </ul>
    );
  }

  protected renderTIEMission(key: string, mission: MissionScore, highScore?: number): JSX.Element {
    const score = mission.score;
    const complete = mission.completed;
    const secret = mission.secret;
    const bonus = mission.bonus;
    const hs = highScore ? this.percentage(mission.score, highScore) : "";

    if (!complete && !score) {
      return "";
    }
    const icons: JSX.Element[] = [
      <i
        class={`material-icons ${complete ? "complete" : "failed"}`}
        aria-label={complete ? "Mission complete" : "Mission failed"}
      >
        {complete ? "done" : "close"}
      </i>
    ];
    if (secret) {
      icons.push(<i class="material-icons secret">check_circle</i>);
    }
    if (bonus) {
      icons.push(<i class="material-icons bonus">check_circle</i>);
    }
    return (
      <div class="list-group-item data d-flex justify-content-between">
        <h6 class="">{key}</h6>
        <div class="d-flex flex-column">
          <span class="d-flex">
            <span class="text-info">{score}</span>
            <span>{icons}</span>
          </span>
          <small class="text-light text-right">{hs}</small>
        </div>
      </div>
    );
  }

  private renderPilotInformation(): JSX.Element {
    const fields: { [key: string]: string | number } = {
      Filename: this.filename,
      Difficulty: this.tfr.PilotDifficultyLabel,
      Status: this.tfr.PilotStatusLabel,
      Rank: this.tfr.PilotRankLabel,
      "Secret Order": this.tfr.SecretOrderLabel,
      Score: this.tfr.Score,
      Skill: this.tfr.SkillScore === -1 ? "Maximum" : this.tfr.SkillScore,
      "Laser hits": this.tfr.LaserLabel,
      "Warhead hits": this.tfr.WarheadLabel,
      Kills: this.tfr.TotalKills,
      Captures: this.tfr.TotalCaptures,
      "Craft lost": this.tfr.CraftLost
    };

    return (
      <ul class="list-group">
        <li class="list-group-item heading">Pilot Information</li>
        {Object.entries(fields).map((value: [string, string]) => this.renderItem(value[0], value[1]))}
      </ul>
    );
  }

  private renderBattles(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Tours of Duty</li>
        {this.tfr.BattleSummary.filter((battle: BattleSummary) => battle.missions.length).map(
          (battle: BattleSummary, b: number) => (
            <li class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1 text-muted">Battle {b + 1}</h5>
                <small>{battle.status}</small>
              </div>
              {battle.missions.map((mission: MissionScore, m: number) =>
                this.renderTIEMission(`Mission ${m + 1}`, mission)
              )}
            </li>
          )
        )}
      </ul>
    );
  }

  private renderKills(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Player Battle Victories</li>
        {this.tfr.BattleVictories.filter((bv: KillSummary) => bv.kills).map((bv: KillSummary) =>
          this.renderItem(bv.craftLabel, bv.kills)
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
            {this.renderItem("Obstacle Course", train.scoreLabel, "", "py-0")}
            {train.missions.map((mission: MissionScore, m: number) =>
              this.renderTIEMission(`Mission ${m + 1}`, mission)
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

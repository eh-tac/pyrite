import { JSX, h } from "@stencil/core";

import { PilotFileController } from "./controller";
import { TrainingSummary, MissionScore, KillSummary, BattleSummary } from "../../model/pilot";
import { Battle } from "../../model/ehtc";
import { PilotFile } from "../../model/XW";

export class XWController extends PilotFileController {
  public constructor(filepath: string, public plt: PilotFile) {
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

    const totalScore: number = this.plt.TotalXWHistoricScore;
    const percent: string =
      scores && scores.total ? this.percentage(totalScore, scores.total.score) : "No high score found";
    const type = battleData.missions === 1 ? "Mission" : "Battle";

    const battleRow = (
      <li class="list-group-item kv heading d-flex justify-content-between">
        <div class="d-flex flex-column">
          <h6 class="my-0">{type} Score</h6>
        </div>
        <div class="d-flex flex-column">
          <span class="text-info font-weight-bold">{totalScore}</span>
          <small class="text-light text-right">{percent}</small>
        </div>
      </li>
    );

    const missionScores = this.plt.BSFMissions;
    const mCount = Math.max(missionScores.length, scores.missions.length);
    const missions: JSX.Element[] = [];
    for (let m = 0; m < mCount; m++) {
      if (missionScores[m]?.completed && scores.missions[m]) {
        missions.push(this.renderXWMission(`Mission ${m + 1}`, missionScores[m], scores.missions[m].score));
      } else if (missionScores[m]?.completed) {
        missions.push(
          this.renderItem(`Mission ${m + 1}`, missionScores[m].score),
          "Too many missions flown",
          "text-danger"
        );
      } else if (scores.missions[m]) {
        missions.push(this.renderItem(`Mission ${m + 1}`, "Not flown", "", "text-danger"));
      } else {
        console.error("Unknown state?");
      }
    }

    return (
      <ul class="list-group">
        <li class="list-group-item heading">BSF Details</li>
        {this.renderItem("Filename", this.filename)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
        {this.renderItem("Kills", this.plt.TotalKills)}
        {this.renderItem("Captures", this.plt.TotalCaptures)}

        {battleRow}
        {missions}
      </ul>
    );
  }

  protected renderXWMission(key: string, mission: MissionScore, highScore?: number): JSX.Element {
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
          <span class="d-inline text-info text-right">{score.toLocaleString()}</span>
          <small class="text-light text-right">{hs}</small>
        </div>
      </div>
    );
  }

  private renderPilotInformation(): JSX.Element {
    const fields: { [key: string]: string | number } = {
      Filename: this.filename,
      Status: this.plt.PilotStatusLabel,
      Rank: this.plt.PilotRankLabel,
      "Rookie Number": this.plt.RookieNumber,
      "Tour Score": this.plt.TotalTODScore.toLocaleString(),
      "Laser hits": this.plt.LaserLabel,
      "Warhead hits": this.plt.WarheadLabel,
      Kills: this.plt.TotalKills,
      Captures: this.plt.TotalCaptures,
      "Craft lost": this.plt.CraftLost
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
        {this.plt.BattleSummary.filter((battle: BattleSummary) => battle.missions.length).map(
          (battle: BattleSummary, b: number) => (
            <li class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1 text-muted">Tour {b + 1}</h5>
                <small>{battle.status}</small>
              </div>
              {battle.missions.map((mission: MissionScore, m: number) =>
                this.renderXWMission(`Mission ${m + 1}`, mission)
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
        {this.plt.BattleVictories.filter((bv: KillSummary) => bv.kills).map((bv: KillSummary) =>
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
        {this.plt.TrainingSummary.map((train: TrainingSummary) => (
          <li class="list-group-item">
            <h5 class="mb-1">{train.craftLabel}</h5>
            {this.renderItem("Obstacle Course", train.scoreLabel, "", "py-0")}
            {train.missions.map((mission: MissionScore, m: number) =>
              this.renderXWMission(`Mission ${m + 1}`, mission)
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

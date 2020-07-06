import { JSX, h } from "@stencil/core";

import { PilotFileController } from "./controller";
import { KillSummary } from "../../model/pilot";
import { Battle } from "../../model/ehtc";
import { XWAPlt } from "../../model/pilot/xwa";
import { XWAMission } from "../../model/pilot/xwa-mission";
import { TriStat } from "../../model/pilot/xvt-team-stats";
export class XWAPltController extends PilotFileController {
  public constructor(filepath: string, public plt: XWAPlt) {
    super(filepath);
  }

  public renderTabs(battleData?: Battle): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [
      ["Summary", this.renderPilotInformation()],
      ["Kills", this.renderKills()]
    ];

    if (battleData) {
      tabs.unshift(["BSF", this.renderBSF(battleData)]);
    }
    return tabs;
  }

  protected renderBSF(battleData: Battle): JSX.Element {
    const scores = battleData.highScores;

    let totalScore: number = 0;
    let percent: string = "";
    let type: string = "";

    const missionScores: XWAMission[] = [];
    let i = 53;
    while (this.plt.missions[i].score) {
      const m = this.plt.missions[i];
      missionScores.push(m);
      i++;
      totalScore += m.total;
    }

    if (battleData.missions === 1) {
      type = "Mission";
      percent = scores && scores["1"] ? this.percentage(totalScore, scores["1"].score) : "No high score found";
    } else {
      type = "Battle";
      percent = scores && scores.length ? this.percentage(totalScore, scores[0].score) : "No high score found";
    }

    const battleRow = (
      <li class="list-group-item kv heading d-flex justify-content-between">
        <h6 class="my-0">{type} Score</h6>
        <div class="d-flex flex-column">
          <span class="text-info font-weight-bold">{totalScore}</span>
          <small class="text-light text-right">{percent}</small>
        </div>
      </li>
    );

    const mCount = Math.max(missionScores.length, scores.length - 1);
    const missions: JSX.Element[] = [];
    missionScores.unshift(missionScores[0]); // make it 1 indexed basically.
    for (let m = 1; m <= mCount; m++) {
      if (missionScores[m] && scores[m]) {
        missions.push(this.renderXWAMission(`Mission ${m}`, missionScores[m], scores[m].score));
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
        {this.renderItem("Rating", this.plt.pilotRating)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}

        {battleRow}
        {missions}
      </ul>
    );
  }

  protected renderXWAMission(key: string, mission: XWAMission, highScore: number): JSX.Element {
    const hs = highScore ? this.percentage(mission.score, highScore) : "";

    return (
      <div class="list-group-item data d-flex justify-content-between">
        <h6 class="text">{key}</h6>

        <div class="d-flex flex-column">
          <span class="d-flex">
            <span class="text-info mr-2">{mission.scoreLabel}</span>
            {/* <i class={`material-icons ${mission.scoreLabel.toLowerCase()}`}>check_circle</i> */}
          </span>
          <small class="text-light">{mission.timeLabel}</small>
          <small class="text-muted">{hs}</small>
        </div>
      </div>
    );
  }

  private renderPilotInformation(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Pilot Information</li>
        {this.renderItem("Filename", this.filename)}

        {this.renderItem("Pilot Name", this.plt.name)}
        {this.renderItem("Tours of Duty Score", this.plt.todScore)}
        {this.renderItem("Azzameen Score", this.plt.azzScore)}
        {this.renderItem("Simulator Score", this.plt.simScore)}
        {this.renderItem("Bonus Points", this.plt.bonus)}
        {this.renderItem("Total Score", this.plt.total)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
      </ul>
    );
  }

  private renderKills(): JSX.Element {
    return (
      <div>
        <ul class="list-group">
          <li class="list-group-item heading">Kills by Type</li>
        </ul>
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>Tour of Duty</th>
              <th>Azzameen</th>
              <th>Combat Sim</th>
            </tr>
          </thead>
          <tbody>{this.plt.BattleVictories.map(s => this.renderTriRow(s))}</tbody>
        </table>
      </div>
    );
  }

  private renderTriRow(stat: TriStat, className?: string): JSX.Element {
    return (
      <tr class={className}>
        <td>{stat.Label}</td>
        <td class={className || "text-info"}>{stat.Exercise}</td>
        <td class={className || "text-info"}>{stat.Melee}</td>
        <td class={className || "text-info"}>{stat.Combat}</td>
      </tr>
    );
  }
}

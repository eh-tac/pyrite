import { JSX, h } from "@stencil/core";

import { PilotFileController } from "./controller";
import { Battle } from "../../model/ehtc";
import { PilotFile, MissionData, TriStat } from "../../model/XWA";
import { BattleSummary } from "../../model/pilot";

export class XWAPltController extends PilotFileController {
  public constructor(filepath: string, public plt: PilotFile) {
    super(filepath);
  }

  public renderTabs(battleData?: Battle): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [
      ["Summary", this.renderPilotInformation()],
      ["Battles", this.renderBattles()],
      ["Kills", this.renderKills()]
    ];

    if (battleData) {
      tabs.unshift(["BSF", this.renderBSF(battleData)]);
    }
    return tabs;
  }

  protected renderBSF(battleData: Battle): JSX.Element {
    let scores = battleData.highScores;
    let battleHS = 0;

    // dirty API format switch
    if (scores["missions"]) {
      battleHS = scores["total"].score;
      scores = scores["missions"];
    } else {
      battleHS = battleData.missions === 1 ? scores["1"].score : scores[0].score;
    }

    let totalScore: number = 0;

    const missionScores: MissionData[] = [];
    let i = 53;
    while (this.plt.MissionData[i].WinCount) {
      const m = this.plt.MissionData[i];
      missionScores.push(m);
      i++;
      totalScore += m.Total;
    }

    const type: string = battleData.missions === 1 ? "Mission" : "Battle";
    const percent: string = battleHS ? this.percentage(totalScore, battleHS) : "No High Score found";

    const battleRow = (
      <li class="list-group-item kv heading d-flex justify-content-between">
        <h6 class="my-0">{type} Score</h6>
        <div class="d-flex flex-column">
          <span class="text-info font-weight-bold">{totalScore}</span>
          <small class="text-light text-right">{percent}</small>
        </div>
      </li>
    );

    const mCount = Math.max(missionScores.length, battleData.missions);
    const missions: JSX.Element[] = [];
    missionScores.unshift(missionScores[0]); // make it 1 indexed basically.
    for (let m = 1; m <= mCount; m++) {
      if (missionScores[m] && scores[m]) {
        missions.push(this.renderXWAMission(`Mission ${m}`, missionScores[m], scores[m].score));
      } else if (missionScores[m]) {
        missions.push(
          this.renderItem(`Mission ${m}`, missionScores[m].Total),
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
        {this.renderItem("Rank", this.plt.CurrentRank)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}

        {battleRow}
        {missions}
      </ul>
    );
  }

  protected renderXWAMission(key: string, mission: MissionData, highScore?: number): JSX.Element {
    const hs = highScore ? this.percentage(mission.Total, highScore) : "";

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
          <small class="text-muted">
            {mission.WinCount} wins from {mission.AttemptCount} attempts
          </small>
        </div>
      </div>
    );
  }

  private renderPilotInformation(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Pilot Information</li>
        {this.renderItem("Filename", this.filename)}

        {this.renderItem("Pilot Name", this.plt.Name)}
        {this.renderItem("Tours of Duty Score", this.plt.TourOfDutyScore)}
        {this.renderItem("Azzameen Score", this.plt.AzzameenScore)}
        {this.renderItem("Simulator Score", this.plt.SimulatorScore)}
        {this.renderItem("Bonus Points", this.plt.BonusScore)}
        {this.renderItem("Total Score", this.plt.TotalScore)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
      </ul>
    );
  }

  private renderBattles(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Tours of Duty</li>
        {this.plt.BattleSummary.filter((battle: BattleSummary) => battle.missions.length).map(
          (battle: BattleSummary, b: number) => {
            if (battle.status === "None") {
              return "";
            } else {
              return (
                <li class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-muted">Battle {b}</h5>
                    <small>{battle.status}</small>
                  </div>
                  {battle.completed &&
                    battle.missions.map((mission: MissionData, m: number) =>
                      this.renderXWAMission(`Mission ${m + 1}`, mission)
                    )}
                </li>
              );
            }
          }
        )}
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
        <td class={className || "text-info"}>{stat.TourOfDuty}</td>
        <td class={className || "text-info"}>{stat.Azzameen}</td>
        <td class={className || "text-info"}>{stat.Simulator}</td>
      </tr>
    );
  }
}

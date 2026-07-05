import { JSX, h } from "@stencil/core";

import { Battle } from "../../model/ehtc";
import { PilotFile } from "../../model/XWVM";
import type { XWVMBattleSummary, XWVMMissionScore } from "../../model/XWVM";
import { PilotFileController } from "./controller";

export class XWVMController extends PilotFileController {
  public constructor(
    filepath: string,
    public pilot: PilotFile,
  ) {
    super(filepath);
  }

  public renderTabs(battleData?: Battle): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [
      ["Summary", this.renderPilotInformation()],
      ["Battles", this.renderBattles()],
    ];

    if (battleData) {
      tabs.unshift(["BSF", this.renderBSF(battleData)]);
    }
    return tabs;
  }

  private renderBSF(battleData: Battle): JSX.Element {
    const scores = battleData.highScores;
    const totalScore = this.pilot.TotalScore;
    const percent = scores && scores.total ? this.percentage(totalScore, scores.total.score) : "No high score found";
    const type = battleData.missions === 1 ? "Mission" : "Battle";
    const missionScores = this.pilot.MissionScores;
    const missionCount = Math.max(missionScores.length, scores.missions.length);
    const missions: JSX.Element[] = [];

    for (let m = 0; m < missionCount; m++) {
      if (missionScores[m] && scores.missions[m]) {
        missions.push(this.renderMission(`Mission ${m + 1}`, missionScores[m], scores.missions[m].score));
      } else if (missionScores[m]) {
        missions.push(
          this.renderItem(`Mission ${m + 1}`, missionScores[m].score, "Too many missions flown", "text-danger"),
        );
      } else if (scores.missions[m]) {
        missions.push(this.renderItem(`Mission ${m + 1}`, "Not flown", "", "text-danger"));
      }
    }

    return (
      <ul class="list-group">
        <li class="list-group-item heading">BSF Details</li>
        {this.renderItem("Filename", this.filename)}
        {this.renderItem(`${type} Score`, totalScore.toLocaleString(), percent, "font-weight-bold")}
        {missions}
      </ul>
    );
  }

  private renderPilotInformation(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Pilot Information</li>
        {this.renderItem("Filename", this.filename)}
        {this.renderItem("Pilot Name", this.pilot.Name || "Unknown")}
        {this.renderItem("Valid XML", this.pilot.Valid ? "Yes" : "No")}
        {this.renderItem("Total Score", this.pilot.TotalScore.toLocaleString())}
        {this.renderItem("Missions", this.pilot.MissionScores.length.toLocaleString())}
      </ul>
    );
  }

  private renderBattles(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">XWVM Battles</li>
        {this.pilot.BattleSummary.map((battle: XWVMBattleSummary) => (
          <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1 text-muted">{battle.battle}</h5>
              <small>{battle.status}</small>
            </div>
            {battle.missions.map((mission: XWVMMissionScore) =>
              this.renderMission(`Mission ${mission.mission}`, mission),
            )}
          </li>
        ))}
      </ul>
    );
  }

  private renderMission(key: string, mission: XWVMMissionScore, highScore?: number): JSX.Element {
    const percent = highScore ? this.percentage(mission.score, highScore) : "";
    const status = mission.completed ? "Complete" : "Incomplete";

    return (
      <div class="list-group-item data d-flex justify-content-between">
        <h6 class="">{key}</h6>
        <div class="d-flex flex-column">
          <span class="d-inline text-info text-right">{mission.score.toLocaleString()}</span>
          <small class="text-light text-right">{mission.name}</small>
          <small class="text-light text-right">{status}</small>
          {percent && <small class="text-muted text-right">{percent}</small>}
        </div>
      </div>
    );
  }
}

import { JSX, h } from "@stencil/core";

import { PilotFileController } from "./controller";
import { Battle } from "../../model/ehtc";
import {
  PL2FileRecord as PilotFile,
  PL2CampaignRecord,
  PL2FactionRecord,
  PLTCategoryTypeRecord
} from "../../model/XvT";
import { TriStat } from "../../model/XvT/pl-2-faction-record";

export class BoPPltController extends PilotFileController {
  public constructor(filepath: string, public plt: PilotFile) {
    super(filepath);
  }

  public renderTabs(battleData?: Battle): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [["Summary", this.renderPilotInformation()]];

    const rebel = this.plt.getRebelFaction();
    if (rebel.hasData()) {
      tabs.push(
        ["Stats (R)", this.renderTeamStats("Rebel", rebel)],
        ["Missions (R)", this.renderTeamMissions("Rebel", rebel)]
      );
    }
    const imprl = this.plt.getImperialFaction();
    if (imprl.hasData()) {
      tabs.push(
        ["Stats (I)", this.renderTeamStats("Imperial", imprl)],
        ["Missions (I)", this.renderTeamMissions("Imperial", imprl)]
      );
    }

    if (battleData) {
      tabs.unshift(["BSF", this.renderBSF(battleData)]);
    }
    return tabs;
  }

  protected renderBSF(battleData: Battle): JSX.Element {
    const scores = battleData.highScores;

    let totalScore: number = 0;

    const missionScores: PL2CampaignRecord[] = [];
    this.plt
      .getCompletedMissions()
      .slice(battleData.offset ?? 0, battleData.missions)
      .forEach(m => {
        if (m.totalCountFlown) {
          missionScores.push(m);
          totalScore += m.bestScore;
        }
      });
    const percent: string =
      scores && scores.total ? this.percentage(totalScore, scores.total.score) : "No high score found";
    const type = battleData.missions === 1 ? "Mission" : "Battle";

    const battleRow = (
      <li class="list-group-item kv heading d-flex justify-content-between">
        <h6 class="my-0">{type} Score</h6>
        <div class="d-flex flex-column">
          <span class="text-info font-weight-bold">{totalScore.toLocaleString()}</span>
          <small class="text-light text-right">{percent}</small>
        </div>
      </li>
    );

    const mCount = Math.max(missionScores.length, scores.missions.length);
    const missions: JSX.Element[] = [];
    for (let m = 0; m < mCount; m++) {
      if (missionScores[m] && scores.missions[m]) {
        missions.push(this.renderBoPCampaign(`Mission ${m + 1}`, missionScores[m], scores.missions[m].score));
      } else if (missionScores[m]) {
        missions.push(
          this.renderItem(
            `Mission ${m + 1}`,
            missionScores[m].bestScore.toLocaleString(),
            "Too many missions flown",
            "text-danger"
          )
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
        {/* {this.renderItem("Rating", this.plt.PilotRatingLabel)} */}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
        {this.renderItem("Kills", this.plt.getKills().toLocaleString())}

        {battleRow}
        {missions}
      </ul>
    );
  }

  protected renderBoPCampaign(key: string, mission: PL2CampaignRecord, highScore?: number): JSX.Element {
    const hs = highScore ? this.percentage(mission.bestScore, highScore) : "";
    return (
      <div class="list-group-item data d-flex justify-content-between">
        <h6 class="">{key}</h6>
        <div class="d-flex flex-column">
          <span class="d-inline text-info text-right">{mission.scoreLabel}</span>
          <small class="text-light text-right">{mission.timeLabel}</small>
          <small class="text-light text-right">{hs}</small>
        </div>
      </div>
    );
  }

  private renderPilotInformation(): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">Pilot Information</li>
        {this.renderItem("Filename", this.filename)}
        {this.renderItem("Pilot Name", this.plt.PilotName)}
        {this.renderItem("Total Score", this.plt.totalScore.toLocaleString())}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
        {this.renderItem("Kills", this.plt.getKills().toLocaleString())}
      </ul>
    );
  }

  private renderTeamStats(label: string, stats: PL2FactionRecord): JSX.Element {
    return (
      <div>
        <ul class="list-group">
          <li class="list-group-item heading">{label} Stats</li>
        </ul>
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>Exercise</th>
              <th>Melee</th>
              <th>Combat</th>
            </tr>
          </thead>
          <tbody>
            {this.renderTriRow(stats.totalFlownSeries)}
            {this.renderTriRow(stats.totalFullKills)}
            {this.renderTriRow(stats.totalLaserFired)}
            {this.renderTriRow(stats.totalLaserHit, "text-muted")}
            {this.renderTriRow(stats.totalWarheadFired)}
            {this.renderTriRow(stats.totalWarheadHit, "text-muted")}
            {this.renderTriRow(stats.totalHiddenCargoFound)}
            {this.renderTriRow(stats.totalLosses)}
            {this.renderTriRow(stats.totalLossesByCollision)}
            <tr>
              <td colSpan={4} class="text-center">
                Kills By Type
              </td>
            </tr>
            {stats.BattleVictories.map(s => this.renderTriRow(s))}
          </tbody>
        </table>
      </div>
    );
  }

  private renderTriRow(stat: TriStat, className?: string): JSX.Element {
    return (
      <tr class={className}>
        <td>{stat.Label}</td>
        <td class={className || "text-info"}>{stat.exercise}</td>
        <td class={className || "text-info"}>{stat.melee}</td>
        <td class={className || "text-info"}>{stat.combat}</td>
      </tr>
    );
  }

  private renderTeamMissions(label: string, stats: PL2FactionRecord): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">{label} Missions</li>
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Campaign</h6>
        </li>
        {stats.missionSPCampaign.map((m, i) =>
          m.isMissionComplete ? this.renderBoPCampaign(`Mission ${i + 1}`, m) : ""
        )}
        {/* <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Melees</h6>
        </li>
        {stats.MeleeMissionData.map((m, i) => (m.AttemptCount ? this.renderBoPCampaign(`Mission ${i + 1}`, m) : ""))}
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Combat</h6>
        </li>
        {stats.CombatMissionData.map((m, i) => (m.AttemptCount ? this.renderBoPCampaign(`Mission ${i + 1}`, m) : ""))} */}
      </ul>
    );
  }
}

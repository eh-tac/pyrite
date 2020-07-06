import { JSX, h } from "@stencil/core";

import { PilotFileController } from "./controller";
import { XvTPlt } from "../../model/pilot";
import { XvTMission } from "../../model/pilot/xvt-mission";
import { Battle } from "../../model/ehtc";
import { XvTTeamStats, TriStat } from "../../model/pilot/xvt-team-stats";
export class XvTPltController extends PilotFileController {
  public constructor(filepath: string, public plt: XvTPlt) {
    super(filepath);
  }

  public renderTabs(battleData?: Battle): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [
      ["Summary", this.renderPilotInformation()],
      ["Stats (R)", this.renderTeamStats("Rebel", this.plt.teamStats[0])],
      ["Stats (I)", this.renderTeamStats("Imperial", this.plt.teamStats[1])],
      ["Missions (R)", this.renderTeamMissions("Rebel", this.plt.teamStats[0])],
      ["Missions (I)", this.renderTeamMissions("Imperial", this.plt.teamStats[1])]
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

    const missionScores: XvTMission[] = [];
    let i = 0;
    while (this.plt.teamStats[1].trainingMissions[i].attempts) {
      const m = this.plt.teamStats[1].trainingMissions[i];
      missionScores.push(m);
      i++;
      totalScore += m.bestScore;
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
        missions.push(this.renderXvTMission(`Mission ${m}`, missionScores[m], scores[m].score));
      } else if (missionScores[m]) {
        missions.push(
          this.renderItem(`Mission ${m}`, missionScores[m].bestScore),
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
        {this.renderItem("Rating", this.plt.currentRating)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
        {this.renderItem("Kills", this.plt.kills)}
        {this.renderItem("Captures", this.plt.kills)}

        {battleRow}
        {missions}
      </ul>
    );
  }

  protected renderXvTMission(key: string, mission: XvTMission, highScore?: number): JSX.Element {
    const hs = highScore ? this.percentage(mission.bestScore, highScore) : "";
    return (
      <div class="list-group-item data d-flex justify-content-between">
        <h6 class="">{key}</h6>
        <div class="d-flex flex-column">
          <span class="d-flex">
            <span class="text-info">{mission.scoreLabel}</span>
            <i class={`material-icons ${mission.rating.toLowerCase()}`}>check_circle</i>
          </span>
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
        {this.renderItem("Pilot Name", this.plt.name)}
        {this.renderItem("Rating", this.plt.currentRating)}
        {this.renderItem("Total Score", this.plt.totalScore)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
        {this.renderItem("Kills", this.plt.kills)}
        {this.renderItem("Craft Losses", this.plt.craftLosses)}
      </ul>
    );
  }

  private renderTeamStats(label: string, stats: XvTTeamStats): JSX.Element {
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
            {this.renderTriRow(stats.MissionsFlown)}
            {this.renderTriRow(stats.Kills)}
            {this.renderTriRow(stats.LaserLabel)}
            {this.renderTriRow(stats.LaserPercent, "text-muted")}
            {this.renderTriRow(stats.WarheadLabel)}
            {this.renderTriRow(stats.WarheadPercent, "text-muted")}
            {this.renderTriRow(stats.HiddenCargo)}
            {this.renderTriRow(stats.CraftLostStat)}
            {this.renderTriRow(stats.Collisions)}
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
        <td class={className || "text-info"}>{stat.Exercise}</td>
        <td class={className || "text-info"}>{stat.Melee}</td>
        <td class={className || "text-info"}>{stat.Combat}</td>
      </tr>
    );
  }

  private renderTeamMissions(label: string, stats: XvTTeamStats): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">{label} Missions</li>
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Training</h6>
        </li>
        {stats.trainingMissions.map((m, i) => (m.attempts ? this.renderXvTMission(`Mission ${i + 1}`, m) : ""))}
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Melees</h6>
        </li>
        {stats.meleeMissions.map((m, i) => (m.attempts ? this.renderXvTMission(`Mission ${i + 1}`, m) : ""))}
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Combat</h6>
        </li>
        {stats.combatMissions.map((m, i) => (m.attempts ? this.renderXvTMission(`Mission ${i + 1}`, m) : ""))}
      </ul>
    );
  }
}

import { JSX, h } from "@stencil/core";

import { PilotFileController } from "./controller";
import { Battle } from "../../model/ehtc";
import { PilotFile, MissionData, TeamStats } from "../../model/XvT";
import { TriStat } from "../../model/XvT/team-stats";

export class XvTPltController extends PilotFileController {
  public constructor(filepath: string, public plt: PilotFile) {
    super(filepath);
  }

  public renderTabs(battleData?: Battle): [string, JSX.Element][] {
    const tabs: [string, JSX.Element][] = [["Summary", this.renderPilotInformation()]];

    const rebel = this.plt.RebelStats;
    if (rebel.hasData()) {
      tabs.push(
        ["Stats (R)", this.renderTeamStats("Rebel", rebel)],
        ["Missions (R)", this.renderTeamMissions("Rebel", rebel)]
      );
    }
    const imprl = this.plt.ImperialStats;
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

    const missionScores: MissionData[] = [];
    let i = 0;
    while (this.plt.ImperialStats.TrainingMissionData[i].AttemptCount) {
      const m = this.plt.ImperialStats.TrainingMissionData[i];
      missionScores.push(m);
      i++;
      totalScore += m.BestScore;
    }

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
        missions.push(this.renderXvTMission(`Mission ${m + 1}`, missionScores[m], scores.missions[m].score));
      } else if (missionScores[m]) {
        missions.push(
          this.renderItem(`Mission ${m + 1}`, missionScores[m].BestScore.toLocaleString()),
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
        {this.renderItem("Rating", this.plt.PilotRatingLabel)}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
        {this.renderItem("Kills", this.plt.Kills)}

        {battleRow}
        {missions}
      </ul>
    );
  }

  protected renderXvTMission(key: string, mission: MissionData, highScore?: number): JSX.Element {
    const hs = highScore ? this.percentage(mission.BestScore, highScore) : "";
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
        {this.renderItem("Pilot Name", this.plt.Name)}
        {this.renderItem("Rating", this.plt.PilotRatingLabel)}
        {this.renderItem("Total Score", this.plt.TotalScore.toLocaleString())}
        {this.renderItem("Lasers", this.plt.LaserLabel, this.plt.LaserPercent)}
        {this.renderItem("Warheads", this.plt.WarheadLabel, this.plt.WarheadPercent)}
        {this.renderItem("Kills", this.plt.Kills.toLocaleString())}
        {this.renderItem("Craft Losses", this.plt.CraftLosses)}
      </ul>
    );
  }

  private renderTeamStats(label: string, stats: TeamStats): JSX.Element {
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

  private renderTeamMissions(label: string, stats: TeamStats): JSX.Element {
    return (
      <ul class="list-group">
        <li class="list-group-item heading">{label} Missions</li>
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Training</h6>
        </li>
        {stats.TrainingMissionData.map((m, i) => (m.AttemptCount ? this.renderXvTMission(`Mission ${i + 1}`, m) : ""))}
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Melees</h6>
        </li>
        {stats.MeleeMissionData.map((m, i) => (m.AttemptCount ? this.renderXvTMission(`Mission ${i + 1}`, m) : ""))}
        <li class="list-group-item kv d-flex justify-content-between">
          <h6 class="my-0 font-weight-bold">Combat</h6>
        </li>
        {stats.CombatMissionData.map((m, i) => (m.AttemptCount ? this.renderXvTMission(`Mission ${i + 1}`, m) : ""))}
      </ul>
    );
  }
}

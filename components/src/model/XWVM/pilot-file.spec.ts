import * as fs from "fs";
import * as path from "path";

import { PilotFile } from "./pilot-file";

function fixture(name: string): string {
  return fs.readFileSync(path.resolve(__dirname, "../../../../fixtures/xwvm", name), "utf-8");
}

describe("XWVM PilotFile", () => {
  it("parses LockeTestA battle scores", () => {
    const pilot = new PilotFile(fixture("LockeTestA.vmpilot"));

    expect(pilot.Valid).toBe(true);
    expect(pilot.Name).toBe("LockeTest");
    expect(pilot.BattleSummary).toHaveLength(1);
    expect(pilot.BattleSummary[0].battle).toBe("XWVMTC2");
    expect(pilot.BattleSummary[0].missions.map(mission => mission.score)).toEqual([2065, 2205, 18636, 11845]);
    expect(pilot.BattleSummary[0].missions.map(mission => mission.mission)).toEqual([1, 2, 3, 4]);
    expect(pilot.listCompleteBattles()).toEqual(["XWVMTC2"]);
    expect(pilot.getBattle("XWVMTC2")).toBe(pilot.BattleSummary[0]);
    expect(pilot.getBattle("TC2")).toBeUndefined();
    expect(pilot.CompletedMissionScores).toEqual([2065, 2205, 18636, 11845]);
  });

  it("includes incomplete named scores from LockeTestB", () => {
    const pilot = new PilotFile(fixture("LockeTestB.vmpilot"));

    expect(pilot.Valid).toBe(true);
    expect(pilot.BattleSummary.map(battle => battle.battle)).toEqual(["XWVMTC2", "XWVMF2", "XWVMF3"]);
    expect(pilot.MissionScores.map(mission => mission.score)).toEqual([2065, 2205, 18636, 11845, 11350, 11622]);

    const f2 = pilot.getBattle("XWVMF2");
    expect(f2?.completed).toBe(false);
    expect(f2?.status).toBe("Incomplete");
    expect(f2?.missions[0]).toMatchObject({
      name: "XWVMF2M1",
      score: 11350,
      completed: false
    });
    expect(pilot.listCompleteBattles()).toEqual(["XWVMTC2", "XWVMF3"]);
    expect(pilot.CompletedOnlyMissionScores).toEqual([2065, 2205, 18636, 11845, 11622]);
  });

  it("marks malformed XML invalid", () => {
    const pilot = new PilotFile("<PilotRecord><PilotGameRecord></PilotRecord>");

    expect(pilot.Valid).toBe(false);
    expect(pilot.Errors.length).toBeGreaterThan(0);
    expect(pilot.BattleSummary).toEqual([]);
    expect(pilot.MissionScores).toEqual([]);
  });
});

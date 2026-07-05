import * as fs from "node:fs";
import { Mission as MissionXWA } from "../../old-assets/model/XWA/mission";
import { Mission as MissionXvT } from "../../old-assets/model/XvT/mission";
import { IMission } from "../pyrite-base";

interface ChildResult {
  status: "ok" | "error";
  missionKey: string;
  durationMs: number;
  playerFlightGroups: string[];
  error?: string;
}

const missionPath = process.env.MISSION_PATH;
const missionKey = process.env.MISSION_KEY || "unknown";

const sendResult = (result: ChildResult): void => {
  if (process.send) {
    process.send(result);
  }
};

if (!missionPath) {
  sendResult({
    status: "error",
    missionKey,
    durationMs: 0,
    playerFlightGroups: [],
    error: "MISSION_PATH was not provided",
  });
  process.exit(1);
}

try {
  const fileBuff = fs.readFileSync(missionPath);
  const hex = fileBuff.buffer.slice(fileBuff.byteOffset, fileBuff.byteOffset + fileBuff.byteLength);

  const start = performance.now();
  const tie: IMission = missionKey.includes("XWA") ? new MissionXWA(hex) : new MissionXvT(hex);
  const playerFlightGroups = tie.FlightGroups.filter((fg) => fg.isPlayer).map((fg) => fg.label.replace(" -", ""));
  const durationMs = performance.now() - start;

  sendResult({
    status: "ok",
    missionKey,
    durationMs,
    playerFlightGroups,
  });

  process.exit(0);
} catch (err) {
  const errorMessage = err instanceof Error ? err.stack || err.message : String(err);
  sendResult({
    status: "error",
    missionKey,
    durationMs: 0,
    playerFlightGroups: [],
    error: errorMessage,
  });
  process.exit(1);
}

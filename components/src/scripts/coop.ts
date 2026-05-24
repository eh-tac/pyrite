import * as fs from "node:fs";
import * as path from "node:path";
import { fork, ForkOptions } from "node:child_process";

const root = path.resolve(__dirname, "../../../../../../pages/downloads/battles/") + "/";
const missions: Record<string, string> = {};

interface CliOptions {
  timeoutMs: number;
  heapMb: number;
  rssMb: number;
  concurrency: number;
  verbose: boolean;
}

interface ChildResult {
  status: "ok" | "error";
  missionKey: string;
  durationMs: number;
  playerFlightGroups: string[];
  error?: string;
}

interface MissionResult {
  ok: boolean;
  missionKey: string;
  durationMs: number;
  playerFlightGroups: string[];
  reason?: string;
}

const parseArgs = (argv: string[]): CliOptions => {
  const getNumArg = (name: string, fallback: number): number => {
    const eqArg = argv.find((arg) => arg.startsWith(`--${name}=`));
    if (eqArg) {
      const v = Number(eqArg.split("=")[1]);
      return Number.isFinite(v) && v > 0 ? v : fallback;
    }

    const index = argv.findIndex((arg) => arg === `--${name}`);
    if (index >= 0 && argv[index + 1]) {
      const v = Number(argv[index + 1]);
      return Number.isFinite(v) && v > 0 ? v : fallback;
    }

    return fallback;
  };

  return {
    timeoutMs: getNumArg("timeoutMs", 15000),
    heapMb: getNumArg("heapMb", 2560),
    rssMb: getNumArg("rssMb", 3840),
    concurrency: Math.max(1, Math.floor(getNumArg("concurrency", 1))),
    verbose: argv.includes("--verbose"),
  };
};

const readRssMb = (pid: number): number => {
  try {
    const statusPath = `/proc/${pid}/status`;
    const status = fs.readFileSync(statusPath, "utf8");
    const match = status.match(/VmRSS:\s+(\d+)\s+kB/i);
    if (!match) {
      return 0;
    }

    return Number(match[1]) / 1024;
  } catch {
    return 0;
  }
};

const runMission = (
  missionKey: string,
  missionPath: string,
  options: CliOptions,
  workerScript: string,
): Promise<MissionResult> => {
  return new Promise((resolve) => {
    let finished = false;
    let timeoutHandle: NodeJS.Timeout;
    let rssHandle: NodeJS.Timeout;

    const done = (result: MissionResult): void => {
      if (finished) {
        return;
      }

      finished = true;
      clearTimeout(timeoutHandle);
      clearInterval(rssHandle);
      resolve(result);
    };

    const execArgv = [`--max-old-space-size=${options.heapMb}`];
    if (workerScript.endsWith(".ts")) {
      execArgv.push("--import=tsx");
    }

    const childOptions: ForkOptions = {
      execArgv,
      env: {
        ...process.env,
        MISSION_KEY: missionKey,
        MISSION_PATH: missionPath,
      },
      stdio: ["ignore", "ignore", "inherit", "ipc"],
    };

    const child = fork(workerScript, [], childOptions);

    timeoutHandle = setTimeout(() => {
      child.kill("SIGKILL");
      done({
        ok: false,
        missionKey,
        durationMs: options.timeoutMs,
        playerFlightGroups: [],
        reason: `timeout after ${options.timeoutMs}ms`,
      });
    }, options.timeoutMs);

    rssHandle = setInterval(() => {
      if (!child.pid || options.rssMb <= 0) {
        return;
      }

      const rssMb = readRssMb(child.pid);
      if (rssMb > options.rssMb) {
        child.kill("SIGKILL");
        done({
          ok: false,
          missionKey,
          durationMs: 0,
          playerFlightGroups: [],
          reason: `rss exceeded ${options.rssMb}MB (current ${rssMb.toFixed(1)}MB)`,
        });
      }
    }, 250);

    child.on("message", (msg: ChildResult) => {
      if (!msg || msg.missionKey !== missionKey) {
        return;
      }

      if (msg.status === "ok") {
        done({
          ok: true,
          missionKey,
          durationMs: msg.durationMs,
          playerFlightGroups: msg.playerFlightGroups,
        });
      } else {
        done({
          ok: false,
          missionKey,
          durationMs: msg.durationMs,
          playerFlightGroups: [],
          reason: msg.error || "child error",
        });
      }
    });

    child.on("error", (err) => {
      done({
        ok: false,
        missionKey,
        durationMs: 0,
        playerFlightGroups: [],
        reason: err.message,
      });
    });

    child.on("exit", (code, signal) => {
      if (!finished && (code !== 0 || signal)) {
        done({
          ok: false,
          missionKey,
          durationMs: 0,
          playerFlightGroups: [],
          reason: `child exited with code=${code} signal=${signal}`,
        });
      }
    });
  });
};

const platforms = ["XvT", "BoP", "XWA"];
// const platforms = ["XWA"];
for (const plat of platforms) {
  // const subgroups = fs.readdirSync(path.join(root, plat)).filter((f) => !f.startsWith("."));
  const subgroups = ["free"];
  for (const sg of subgroups) {
    const sgPath = path.join(root, plat, sg);
    const bats = fs
      .readdirSync(sgPath)
      .filter((f) => !f.startsWith(".") && fs.statSync(path.join(sgPath, f)).isDirectory());
    // const bats = ["1"];
    for (const bat of bats) {
      const batPath = path.join(sgPath, bat);
      if (!fs.existsSync(batPath)) {
        console.log(`Directory ${batPath} does not exist, skipping...`);
        continue;
      }
      const ms = fs.readdirSync(batPath).filter((f) => f.toLowerCase().endsWith(".tie"));
      for (const m of ms) {
        missions[`${plat}/${sg}/${bat}/${m}`] = path.join(batPath, m);
      }
    }
  }
}

const run = async (): Promise<void> => {
  const options = parseArgs(process.argv.slice(2));
  const workerScriptJs = path.join(__dirname, "coop-worker.js");
  const workerScriptTs = path.join(__dirname, "coop-worker.ts");
  const workerScript = fs.existsSync(workerScriptJs) ? workerScriptJs : workerScriptTs;
  const missionEntries = Object.entries(missions);

  let index = 0;
  let processed = 0;
  const readTimes: number[] = [];
  const failures: string[] = [];
  const successes: string[] = [];

  const nextMission = (): [string, string] | undefined => {
    const m = missionEntries[index];
    index += 1;
    return m;
  };

  const workerLoop = async (): Promise<void> => {
    while (true) {
      const mission = nextMission();
      if (!mission) {
        return;
      }

      const [missionKey, missionPath] = mission;
      if (options.verbose) {
        console.log("trying", missionPath);
      }

      const result = await runMission(missionKey, missionPath, options, workerScript);
      processed += 1;

      if (result.ok) {
        readTimes.push(result.durationMs);
        if (result.playerFlightGroups.length > 1) {
          console.log(
            `\t ${missionKey} has ${result.playerFlightGroups.length} player flight groups: ${result.playerFlightGroups.join(", ")}`,
          );
          successes.push(
            `${missionKey} has ${result.playerFlightGroups.length} player flight groups: ${result.playerFlightGroups.join(", ")}`,
          );
        }
      } else {
        failures.push(`${missionKey}: ${result.reason || "unknown failure"}`);
      }

      if (processed % 10 === 0 || processed === missionEntries.length) {
        console.log(`Processed ${processed}/${missionEntries.length} missions so far...`);
      }
    }
  };

  const loops: Array<Promise<void>> = [];
  for (let i = 0; i < options.concurrency; i += 1) {
    loops.push(workerLoop());
  }

  await Promise.all(loops);

  const total = readTimes.reduce((a, b) => a + b, 0);
  console.log(`Done processing ${processed} missions.`);
  console.log(`Success: ${readTimes.length}, Failed: ${failures.length}`);
  console.log("Total parse time (successful missions):", total);
  console.log("Average parse time:", readTimes.length > 0 ? total / readTimes.length : 0);

  if (failures.length > 0) {
    console.log("Failures:");
    for (const f of failures) {
      console.log(`  - ${f}`);
    }
  }

  if (successes.length > 0) {
    console.log("Successes:");
    for (const s of successes) {
      console.log(`  - ${s}`);
    }
  }
};

run().catch((err) => {
  console.error("Fatal error running coop parser", err);
  process.exit(1);
});

import * as fs from "fs";
import * as path from "path";
import * as progress from "cli-progress";
import { Mission } from "../model/XWA";
import { CraftType } from "../model/XWA/constants";

const root = "/home/tom/tiecorps/pages/downloads/battles/";
const free = `${root}free/`;

function isDir(path) {
  const stat = fs.statSync(path);
  return stat.isDirectory();
}

let missions = [];
const platforms = ["XWA"];
for (const plat of platforms) {
  const subgroups = fs.readdirSync(`${root}${plat}`).filter(f => !f.startsWith("."));
  for (const sg of subgroups) {
    const bats = fs
      .readdirSync(`${root}${plat}/${sg}`)
      .filter(f => !f.startsWith(".") && !f.endsWith("e") && isDir(`${root}${plat}/${sg}/${f}`));
    for (const bat of bats) {
      const ms = fs.readdirSync(`${root}${plat}/${sg}/${bat}`).filter(f => f.toLowerCase().endsWith(".tie"));
      for (const m of ms) {
        missions.push(`${root}${plat}/${sg}/${bat}/${m}`);
      }
    }
  }
}

const progressBar = new progress.SingleBar(
  {
    format: "Analysing Missions: [{bar}] {percentage}% - {value}/{total} - {duration_formatted} - {last}",
    stopOnComplete: true
  },
  progress.Presets.shades_grey
);

progressBar.start(missions.length, 0, {
  last: "Starting"
});
let done = 0;

const found = [];
for (const m of missions) {
  const mPath = path.resolve(m);
  const name = path.basename(mPath);
  const fileBuff = fs.readFileSync(mPath);
  const hex = fileBuff.buffer.slice(fileBuff.byteOffset, fileBuff.byteOffset + fileBuff.byteLength);

  const mshort = m.replace("/home/tom/tiecorps/pages/downloads/battles/XWA/", "");
  try {
    const tie = new Mission(hex);
    for (const fg of tie.FlightGroups) {
      if (fg.CraftType === CraftType.executorclassStarDestroyer) {
        found.push(`${mshort} - ${fg}`);
      }
    }
  } catch (e) {
    console.log("There was an error processing", m, e);
  }

  progressBar.update(++done, { last: name });
}

console.log(found.join("\n"));

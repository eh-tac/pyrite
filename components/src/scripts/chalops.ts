import * as fs from "fs";
import * as path from "path";
import * as extract from "extract-zip";
import * as progress from "cli-progress";
import { Mission } from "../model/XvT";
import { loadMission } from "../model/util";

const battleDir = "/mnt/c/Users/pickl/projects/tac work/to test/ChalOps/";
const missionPaths = [];

const folders = fs.readdirSync(battleDir).filter(f => !f.startsWith("."));
for (const folder of folders) {
  const missionFiles = fs.readdirSync(`${battleDir}${folder}`).filter(f => f.endsWith(".tie"));
  for (const mission of missionFiles) {
    missionPaths.push(`${folder}/${mission}`);
  }
}

const progressBar = new progress.SingleBar(
  {
    format: "Validating Missions: [{bar}] {percentage}% - {value}/{total} - {last}",
    stopOnComplete: true
  },
  progress.Presets.shades_grey
);

// progressBar.start(missionPaths.length, 0, {
//   last: "Starting"
// });

let done = 0;
for (const path of missionPaths.slice(0, 5)) {
  const fullPath = `${battleDir}${path}`;

  if (fs.existsSync(fullPath)) {
    const xvtMission = loadMission(fullPath) as Mission;
    if (xvtMission) {
      console.log(
        "\n\nValidating",
        path,
        xvtMission.FileHeader.NumFGs,
        "FGs",
        xvtMission.FileHeader.NumMessages,
        "messages"
      );
      xvtMission.validate();
    }
    // progressBar.update(++done, { last: path });
  } else {
    progressBar.update(++done, { last: path });
    // console.log("Couldnt find", path);
  }
}

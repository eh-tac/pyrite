import * as fs from "fs";
import { argv } from "process";
import { Mission } from "../model/XW";

const path = argv[2];
const fileBuff = fs.readFileSync(path);
const hex = fileBuff.buffer.slice(fileBuff.byteOffset, fileBuff.byteOffset + fileBuff.byteLength);

console.log(path.split("/").pop());
const mission = new Mission(hex);
mission.FlightGroups.forEach(fg => {
  console.log(fg.toString());
});

// const battleDir = "../../battles/";
// const extracted = "../../extracted/";
// let battles = [];

// const platforms = fs.readdirSync(battleDir).filter(f => !f.startsWith("."));
// for (const plat of platforms) {
//   const subgroups = fs.readdirSync(`${battleDir}${plat}`).filter(f => !f.startsWith("."));
//   for (const sg of subgroups) {
//     const zips = fs.readdirSync(`${battleDir}${plat}/${sg}`).filter(f => f.endsWith(".zip"));
//     for (const zip of zips) {
//       battles.push(`${plat}/${sg}/${zip}`);
//     }
//   }
// }

// const progressBar = new progress.SingleBar(
//   {
//     format: "Extracting Battles: [{bar}] {percentage}% - {value}/{total} - {last}",
//     stopOnComplete: true
//   },
//   progress.Presets.shades_grey
// );

// progressBar.start(battles.length, 0, {
//   last: "Starting"
// });
// let done = 0;
// for (const zip of battles) {
//   const ext = zip.replace(".zip", "");
//   const ePath = path.resolve(`${extracted}${ext}`);
//   const zPath = path.resolve(`${battleDir}${zip}`);
//   const name = path.basename(ePath);

//   if (!fs.existsSync(ePath)) {
//     extract(zPath, { dir: ePath }, function(e) {
//       progressBar.update(++done, { last: name });
//     });
//   } else {
//     progressBar.update(++done, { last: name });
//   }
// }

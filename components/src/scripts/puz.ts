import * as fs from "fs";
import * as path from "path";
import * as progress from "cli-progress";
import { Crossword } from "../model/Puz";

console.log(__dirname);
const puz = __dirname + "/../assets/LR007.puz";
const puzStr = fs.readFileSync(puz, "UTF8");
const puzB = fs.readFileSync(puz);
console.log(puzStr);

const x = new Crossword(puzB);
console.log(x);

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

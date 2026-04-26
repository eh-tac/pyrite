import * as fs from 'fs';
import * as path from 'path';
import * as progress from 'cli-progress';
import { Mission } from '../model/TIE';

const root = "../../extracted/";
let missions = [];

const platforms = ["TIE"];
for (const plat of platforms) {
  const subgroups = fs.readdirSync(`${root}${plat}`).filter(f => !f.startsWith('.'));
  for (const sg of subgroups) {
    const bats = fs.readdirSync(`${root}${plat}/${sg}`).filter(f => !f.startsWith('.'));
    for (const bat of bats) {
      const ms = fs.readdirSync(`${root}${plat}/${sg}/${bat}`).filter(f => f.toLowerCase().endsWith('.tie'));
      for (const m of ms) {
        missions.push(`${plat}/${sg}/${bat}/${m}`);
      }
    }
  }
}

const progressBar = new progress.SingleBar({
  format: 'Analysing Missions: [{bar}] {percentage}% - {value}/{total} - {duration_formatted} - {last}',
  stopOnComplete: true,
}, progress.Presets.shades_grey);

progressBar.start(missions.length, 0, {
  last: 'Starting'
});
let done = 0;

const freedom = [];
const allNames = new Map<string, number>();
for (const m of missions) {
  const mPath = path.resolve(`${root}${m}`);
  const name = path.basename(mPath);
  const fileBuff = fs.readFileSync(mPath);
  const hex = fileBuff.buffer.slice(fileBuff.byteOffset, fileBuff.byteOffset + fileBuff.byteLength);
  try {
    const tie = new Mission(hex);
    const names = new Set<string>();
    for (const fg of tie.FlightGroups) {
      const l = fg.label;
      names.add(l);
      if (l.toLowerCase().includes('freedom')) {
        freedom.push(`${m} has ${l}`);
      }
    }
    for (const n of names.values()) {
      if (!allNames.has(n)) {
        allNames.set(n, 0);
      }
      allNames.set(n, allNames.get(n) + 1);
    }
  } catch (e) {
    console.log("There was an error processing", m, e);
  }

  progressBar.update(++done, { last: name });
}
const entries = Array.from(allNames.entries()).sort((a, b) => b[1] - a[1]);
console.log('50 most common:')
console.log(entries.slice(0, 50));
console.log('Freedom variants:')
console.log(freedom);
console.log(freedom.length);
console.log(entries.filter(a => a[0].startsWith('CRS') || a[0].startsWith('CRL')));
import zlib from 'zlib';
import * as fs from 'fs';

const battleDir = "../../../battles/";
const battles = [];

const platforms = fs.readdirSync(battleDir);
for (const plat of platforms) {
  const subgroups = fs.readdirSync(`${battleDir}${plat}`);
  for (const sg of subgroups) {
    const zips = fs.readdirSync(`${battleDir}${plat}/${sg}`).filter(f => f.endsWith('.zip'));
    for (const zip of zips) {
      battles.push(`${plat}/${sg}/${zip}`);
    }
  }
}
console.log(battles);

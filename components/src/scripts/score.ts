import { readFileSync } from "node:fs";
import { Mission } from "../model/XWA";

console.log(__dirname);

const scoreHex = readFileSync(`${__dirname}/../assets/xwascore.tie`);
const xwa = new Mission(scoreHex.buffer);
console.log(xwa);

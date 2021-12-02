import * as fs from "fs";
import { Mission } from "../model/XWA";

const root = "/home/tom/tiecorps/pages/downloads/battles/XWA/";

const fileBuff = fs.readFileSync(`${root}free/XWAF32/1B8M1AvengerFury.tie`);
const hex = fileBuff.buffer.slice(fileBuff.byteOffset, fileBuff.byteOffset + fileBuff.byteLength);
const tie = new Mission(hex);
console.log(JSON.stringify(tie.FileHeader, null, 2));

import * as fs from "fs";
import { PyriteGenerator } from "./generator";
import { TypeScriptWriter } from "./typescript-writer";
import { PHPWriter } from "./php-writer";

function mg(plt: string): PyriteGenerator {
  return new PyriteGenerator(
    plt,
    fs.readFileSync(`src/build/${plt}/structs.txt`, { encoding: "UTF8" }),
    fs.readFileSync(`src/build/${plt}/const.txt`, { encoding: "UTF8" })
  );
}

const tieG = mg("TIE");
const tieW = new TypeScriptWriter("src", tieG);
tieW.write();
const tieP = new PHPWriter("../lib", tieG);
tieP.write();

// const xwG = mg("XW");
// const xwW = new TypeScriptWriter("src", xwG);
// xwW.write();
// const xwP = new PHPWriter("../lib", xwG);
// xwP.write();

// const vG = mg("XvT");
// const vW = new TypeScriptWriter("src", vG);
// const vP = new PHPWriter("../lib", vG);
// vW.write();
// vP.write();

const wG = mg("XWA");
const wW = new TypeScriptWriter("src", wG);
const wP = new PHPWriter("../lib", wG);
wW.write();
wP.write();

// const lfdG = mg("LFD");
// const lfgW = new TypeScriptWriter("src", lfdG);
// lfgW.write();

// const pG = mg("Puz");
// const pw = new TypeScriptWriter("src", pG);
// pw.write();
// const pp = new PHPWriter("../../../../../xword/src/Model", pG, "App\\Model");
// pp.write();

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

// make generators
const [tieG, xwG, xvtG, xwaG, lfdG, puzG] = [mg("TIE"), mg("XW"), mg("XvT"), mg("XWA"), mg("LFD"), mg("Puz")];

// make writers
[
  // new TypeScriptWriter("src", tieG),
  new PHPWriter("../lib", tieG),
  new TypeScriptWriter("src", xwG),
  new PHPWriter("../lib", xwG),
  new TypeScriptWriter("src", xvtG),
  new PHPWriter("../lib", xvtG),
  new TypeScriptWriter("src", xwaG),
  new PHPWriter("../lib", xwaG),
  new TypeScriptWriter("src", lfdG)
].forEach(writer => writer.write());

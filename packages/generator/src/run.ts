import * as fs from "fs";
import { PyriteGenerator } from "./generator";
import { TypeScriptWriter } from "./typescript-writer";
import { PHPWriter } from "./php-writer";

function mg(plt: string): PyriteGenerator {
  return new PyriteGenerator(
    plt,
    fs.readFileSync(`src/${plt}/structs.txt`, { encoding: "UTF8" }),
    fs.readFileSync(`src/${plt}/const.txt`, { encoding: "UTF8" })
  );
}

// make generators
const [tieG, xwG, xvtG, xwaG, lfdG, puzG] = [mg("TIE"), mg("XW"), mg("XvT"), mg("XWA"), mg("LFD"), mg("Puz")];

// make writers
[
  new TypeScriptWriter("../TIE/src", "../components/src", tieG),
  new PHPWriter("../../lib", tieG),
  new TypeScriptWriter("../XW/src", "../components/src", xwG),
  new PHPWriter("../../lib", xwG),
  new TypeScriptWriter("../XvT/src", "../components/src", xvtG),
  new PHPWriter("../../lib", xvtG),
  new TypeScriptWriter("../XWA/src", "../components/src", xwaG),
  new PHPWriter("../../lib", xwaG),
  new TypeScriptWriter("../components/src/model/LFD", "../components/src", lfdG)
].forEach(writer => writer.write());

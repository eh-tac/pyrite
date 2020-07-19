import * as fs from "fs";
import { PyriteGenerator } from "./generator";
import { TypeScriptWriter } from "./typescript-writer";

function mg(plt: string): PyriteGenerator {
  return new PyriteGenerator(
    plt,
    fs.readFileSync(`src/build/${plt}/structs.txt`, { encoding: "UTF8" }),
    fs.readFileSync(`src/build/${plt}/const.txt`, { encoding: "UTF8" })
  );
}

const tieG = mg("TIE");
const tieW = new TypeScriptWriter("src/x", tieG);
tieW.write();

const xwG = mg("XW");
const xwW = new TypeScriptWriter("src", xwG);
xwW.write();

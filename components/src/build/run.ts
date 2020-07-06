import * as fs from "fs";
import { PyriteGenerator } from "./generator";
import { TypeScriptWriter } from "./typescript-writer";

const gen = new PyriteGenerator(
  "TIE",
  fs.readFileSync("src/build/TIE/structs.txt", { encoding: "UTF8" }),
  fs.readFileSync("src/build/TIE/const.txt", { encoding: "UTF8" })
);
const writeTS = new TypeScriptWriter("src/x", gen);
writeTS.write();

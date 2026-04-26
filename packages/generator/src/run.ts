import * as fs from "fs";
import { PyriteGenerator } from "./generator";
import { TypeScriptWriter } from "./typescript-writer";
import { PHPWriter } from "./php-writer";

const bopFiles: string[] = [
  "mission-bop.ts",
  "pl-2-campaign-progress-state.ts",
  "pl-2-campaign-record.ts",
  "pl-2-campaign-state.ts",
  "pl-2-campaign-status-sp-record.ts",
  "pl-2-debrief-record.ts",
  "pl-2-faction-record.ts",
  "pl-2-file-record.ts"
];

function extractBopArtifacts(): void {
  const xvtRoot = "../XvT/src";
  const bopRoot = "../BoP/src";
  const bopBaseRoot = `${bopRoot}/base`;
  const xvtBaseRoot = `${xvtRoot}/base`;
  fs.mkdirSync(bopBaseRoot, { recursive: true });

  for (const file of bopFiles) {
    const xvtPath = `${xvtRoot}/${file}`;
    if (fs.existsSync(xvtPath)) {
      const bopPath = `${bopRoot}/${file}`;
      if (fs.existsSync(bopPath)) {
        fs.unlinkSync(xvtPath);
      } else {
        fs.renameSync(xvtPath, bopPath);
      }
    }

    const baseFile = file === "mission-bop.ts" ? "mission-bop-base.ts" : file.replace(".ts", "-base.ts");
    const xvtBasePath = `${xvtBaseRoot}/${baseFile}`;
    if (fs.existsSync(xvtBasePath)) {
      fs.renameSync(xvtBasePath, `${bopBaseRoot}/${baseFile}`);
    }
  }

  fs.copyFileSync(`${xvtRoot}/constants.ts`, `${bopRoot}/constants.ts`);
  fs.writeFileSync(
    `${bopRoot}/index.ts`,
    [
      `export { Constants } from "./constants";`,
      `export { MissionBOP } from "./mission-bop";`,
      `export { PL2CampaignProgressState } from "./pl-2-campaign-progress-state";`,
      `export { PL2CampaignRecord } from "./pl-2-campaign-record";`,
      `export { PL2CampaignState } from "./pl-2-campaign-state";`,
      `export { PL2CampaignStatusSPRecord } from "./pl-2-campaign-status-sp-record";`,
      `export { PL2DebriefRecord } from "./pl-2-debrief-record";`,
      `export { PL2FactionRecord } from "./pl-2-faction-record";`,
      `export { PL2FileRecord } from "./pl-2-file-record";`
    ].join("\n")
  );

  const xvtIndex = fs
    .readFileSync(`${xvtRoot}/index.ts`, { encoding: "UTF8" })
    .split("\n")
    .filter((line: string) => !bopFiles.some((file: string) => line.includes(file.replace(".ts", ""))));
  fs.writeFileSync(`${xvtRoot}/index.ts`, xvtIndex.join("\n"));
}

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

extractBopArtifacts();

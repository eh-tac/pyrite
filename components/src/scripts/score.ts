import { readFileSync, writeFileSync } from "node:fs";
import { FlightGroup, Mission } from "../model/XWA";
import { CraftType } from "../model/XWA/constants";

console.log(__dirname);

const scoreHex = readFileSync(`${__dirname}/../assets/xwascore.tie`);
const xwa = new Mission(scoreHex.buffer);

const targetFg = xwa.FlightGroups.find((fg) => fg.Name === "target") as FlightGroup;
const [msgId, msgCraft, msgPoints] = xwa.Messages;

const types = [CraftType.xwing, CraftType.ywing, CraftType.awing, CraftType.bwing];
types.forEach((type, idx) => {
  const pts = "unknown";
  targetFg.CraftType = type;
  msgId.Message = `Mission ${idx + 1}`;
  msgCraft.Message = `${targetFg.GroupAILabel} ${targetFg.CraftTypeLabel}`;
  msgPoints.Message = `Expected score: ${pts}`;

  const out = xwa.toHexBuffer();
  const outPath = `${__dirname}/../assets/score${idx + 1}.tie`;
  console.log(`Writing ${outPath}...`);
  writeFileSync(outPath, Buffer.from(out));
});

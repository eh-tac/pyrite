import { readFileSync, writeFileSync } from "node:fs";
import { resolve } from "node:path";
import { PL2FileRecord } from "../model/XvT";

function toArrayBuffer(buffer: Buffer): ArrayBuffer {
  return buffer.buffer.slice(buffer.byteOffset, buffer.byteOffset + buffer.byteLength) as ArrayBuffer;
}

describe("pl2-file-record", () => {
  const fixturePath = resolve(__dirname, "../../../test/data/VanguardBOP0.pl2");
  const fixture = readFileSync(fixturePath);
  let pl2 = new PL2FileRecord(toArrayBuffer(fixture));

  beforeEach(() => {
    pl2 = new PL2FileRecord(toArrayBuffer(fixture));
  });

  it("campaign total score matches completed mission scores", () => {
    const scores = pl2.getCompletedMissionScores(true);
    const scoreSum = scores.reduce((sum: number, score: number) => {
      return sum + score;
    }, 0);

    const [imperial, rebel] = pl2.spCampaignState;

    expect(scores).toHaveLength(15);
    expect(scoreSum).toBe(1729938);

    const bestScores = pl2.faction[1].statusSPCampaign.map((camp) => camp.bestScore);
    expect(Math.max(...bestScores)).toBe(scoreSum);
  });

  it("can edit the scores", () => {
    const [rebel, imperial] = pl2.faction;
    rebel.missionSPCampaign[75].bestScore = 153460;
    rebel.missionSPCampaign[85].bestScore = 211900;

    const scores = pl2.getCompletedMissionScores(true);
    const scoreSum = scores.reduce((sum: number, score: number) => {
      return sum + score;
    }, 0);

    expect(scores).toHaveLength(15);
    expect(scoreSum).toBe(2096418);

    const bestScores = rebel.statusSPCampaign.map((camp) => camp.bestScore);
    expect(Math.max(...bestScores)).toBe(scoreSum);

    const editPath = resolve(__dirname, "../../../test/data/edit/VanguardBOP0.pl2");
    const output = Buffer.from(pl2.toHexBuffer());
    writeFileSync(editPath, output);
  });

  it("output matches the input file", () => {
    const output = Buffer.from(pl2.toHexBuffer());
    let differentBytes = 0;

    expect(output.length).toBe(fixture.length);

    for (let i = 0; i < output.length; i++) {
      if (output[i] !== fixture[i]) {
        differentBytes += 1;
      }
    }

    expect(differentBytes).toBeLessThan(20);
  });
});

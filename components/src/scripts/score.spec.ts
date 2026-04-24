import { readFileSync } from "node:fs";
import { Mission } from "../model/XWA";

describe("xwa-serialization", () => {
  const scoreHex = readFileSync(`${__dirname}/../assets/xwascore.tie`);
  const xwa = new Mission(scoreHex.buffer);

  it("outputs the same as it inputs", () => {
    const outputHex = xwa.toHexString();
    expect(outputHex).toEqual(scoreHex.toString("hex").toUpperCase());
  });
});

import { readFileSync, writeFileSync } from "node:fs";
import { Mission } from "@pyrite/xwa";

describe("xwa-serialization", () => {
  const scoreHex = readFileSync(`${__dirname}/../assets/xwascore.tie`);
  const xwa = new Mission(scoreHex.buffer.slice(0, scoreHex.buffer.byteLength));

  function expectBufferMatch(actual: ArrayBuffer, expected: ArrayBuffer) {
    expect(actual).toEqual(expected);
    expect(actual.byteLength).toEqual(expected.byteLength);
    const aView = new DataView(actual);
    const eView = new DataView(expected);
    for (let i = 0; i < actual.byteLength; i++) {
      if (aView.getUint8(i) !== eView.getUint8(i)) {
        const hexOffset = `0x${i.toString(16).padStart(2, "0")}`;
        console.error(`Byte ${i} (${hexOffset}) mismatch: ${aView.getUint8(i)} !== ${eView.getUint8(i)}`);
      }
      expect(aView.getUint8(i)).toEqual(eView.getUint8(i));
    }
  }

  it("file header output", () => {
    const header = xwa.FileHeader;
    const out = header.toHexBuffer();
    expectBufferMatch(out, scoreHex.buffer.slice(0, header.getLength()));
  });

  it("flight group output", () => {
    for (let i = 0; i < xwa.FileHeader.NumFGs; i++) {
      const t = xwa.FlightGroups[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("message output", () => {
    for (let i = 0; i < xwa.FileHeader.NumMessages; i++) {
      const t = xwa.Messages[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("global goal output", () => {
    for (let i = 0; i < 10; i++) {
      const t = xwa.GlobalGoals[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("team output", () => {
    for (let i = 0; i < 10; i++) {
      const t = xwa.Teams[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("briefing output", () => {
    for (let i = 0; i < 2; i++) {
      const t = xwa.Briefings[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("fg goal string output", () => {
    for (let i = 0; i < xwa.FGGoalStrings.length; i++) {
      const t = xwa.FGGoalStrings[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("global goal string output", () => {
    for (let i = 0; i < 360; i++) {
      const t = xwa.GlobalGoalStrings[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("order string output", () => {
    for (let i = 0; i < 3072; i++) {
      const t = xwa.OrderStrings[i];
      const out = t.toHexBuffer();
      expectBufferMatch(out, t.hex.slice(0, t.getLength()));
    }
  });

  it("handles whole mission", () => {
    const out = xwa.toHexBuffer();
    expect(out).toEqual(scoreHex.buffer.slice(0, xwa.getLength()));

    const outPath = `${__dirname}/../assets/tmp.tie`;
    writeFileSync(outPath, Buffer.from(out));

    const readOut = readFileSync(outPath);
    expect(readOut.buffer).toEqual(scoreHex.buffer);
    expect(readOut.buffer.byteLength).toEqual(scoreHex.buffer.byteLength);
  });

  it("gets the description notes", () => {
    const [start, win, lose] = xwa.DescriptionNotes;
    expect(start).toEqual("start");
    expect(win).toEqual("win");
    expect(lose).toEqual("lose");
  });

  it("gets the descriptions", () => {
    const [win, lose, start] = xwa.Descriptions;
    expect(start).toEqual("#this is a test of the start");
    expect(win).toEqual("this is the win");
    expect(lose).toEqual("#you failed");
  });
});

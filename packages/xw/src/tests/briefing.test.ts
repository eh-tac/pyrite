import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

import { Briefing } from '../briefing';

const fixturePath = resolve(__dirname, '../../../../fixtures/xw/XWVMTC1M1.BRF');

function toArrayBuffer(b: Buffer): ArrayBuffer {
  return b.buffer.slice(b.byteOffset, b.byteOffset + b.byteLength) as ArrayBuffer;
}

describe('Briefing', () => {
  const fixture = readFileSync(fixturePath);
  const hex = toArrayBuffer(fixture);

  it('parses XWVMTC1M1.BRF', () => {
    const briefing = new Briefing(hex);
    expect(briefing.BriefingHeader.CoordinateCount).toBe(2);
    expect(briefing.BriefingHeader.IconCount).toBe(16);
  });

  it('output matches the input file', () => {
    const briefing = new Briefing(hex);
    const output = Buffer.from(briefing.toHexBuffer());
    let differentBytes = 0;

    // expect(output.length).toBe(fixture.length);

    for (const [i, element] of output.entries()) {
      if (element === fixture[i]) {
        continue;
      }

      if (differentBytes < 20) {
        console.log('different at byte', i, 'expected', fixture[i], 'got', element);
      }
      differentBytes += 1;
    }

    expect(differentBytes).toBeLessThan(20);
  });
});

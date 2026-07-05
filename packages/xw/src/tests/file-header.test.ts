import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

import { Mission } from '../mission';

const fixturePath = resolve(__dirname, '../../../../fixtures/xw/XWVMTC1M1.XWI');

function toArrayBuffer(b: Buffer): ArrayBuffer {
  return b.buffer.slice(b.byteOffset, b.byteOffset + b.byteLength) as ArrayBuffer;
}

describe('File Header', () => {
  const fixture = readFileSync(fixturePath);
  const hex = toArrayBuffer(fixture);
  const mission = new Mission(hex);

  it('parses XWVMTC1M1.XWI', () => {
    const header = mission.FileHeader;
    const [m1, m2, m3] = header.CompletionMessage;
    expect(m1).toBe('<Sarin> Fried Calamari Rings! There goes the Cruiser!');
    expect(m2).toBe('<Sarin> Great work Avenger and Crusader - you Ruled the Void!');
    expect(m3).toBe('<Hev> Great bombing work there! Thanks for the escort Avengers');
  });

  it('output matches the input file', () => {
    const header = mission.FileHeader;
    const output = Buffer.from(header.toHexBuffer());
    let differentBytes = 0;

    const input = Buffer.from(hex.slice(0, header.getLength()));
    expect(output.length).toBe(input.length);

    for (const [i, element] of output.entries()) {
      if (element === input[i]) {
        continue;
      }

      if (differentBytes < 20) {
        console.log('different at byte', i, 'expected', input[i], 'got', element);
      }
      differentBytes += 1;
    }

    expect(differentBytes).toBe(0);
  });
});

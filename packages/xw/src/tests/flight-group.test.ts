import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

import { Mission } from '../mission';

const fixturePath = resolve(__dirname, '../../../../fixtures/xw/XWVMTC1M1.XWI');

function toArrayBuffer(b: Buffer): ArrayBuffer {
  return b.buffer.slice(b.byteOffset, b.byteOffset + b.byteLength) as ArrayBuffer;
}

describe('Flight Group', () => {
  const fixture = readFileSync(fixturePath);
  const hex = toArrayBuffer(fixture);
  const mission = new Mission(hex);

  it('parses XWVMTC1M1.XWI', () => {
    const groups = mission.FlightGroups;
    const [g1, g2, g3] = groups;
    expect(g1.Name).toBe('Avenger 2-');
    expect(g2.Name).toBe('Avenger 2-');
    expect(g3.Name).toBe('Avenger 1-');
  });

  it('output matches the input file', () => {
    const g1 = mission.FlightGroups[0];
    const output = Buffer.from(g1.toHexBuffer());
    let differentBytes = 0;

    const input = Buffer.from(hex.slice(0xce, 0xce + g1.getLength()));
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

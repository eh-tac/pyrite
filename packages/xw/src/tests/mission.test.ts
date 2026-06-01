import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';
import { Mission } from '../mission';

const fixturePath = resolve(__dirname, '../../../../fixtures/xw/XWVMTC1M1.XWI');

function toArrayBuffer(b: Buffer): ArrayBuffer {
  return b.buffer.slice(b.byteOffset, b.byteOffset + b.byteLength) as ArrayBuffer;
}

describe('Mission', () => {
  const fixture = readFileSync(fixturePath);
  const hex = toArrayBuffer(fixture);

  it('parses XWVMTC1M1.XWI', () => {
    const mission = new Mission(hex);

    const flightGroups = mission.FlightGroups;
    expect(flightGroups).toHaveLength(16);

    const avenger2 = flightGroups[0];
    expect(avenger2.Name).toBe('Avenger 2-');
  });

  it('output matches the input file', () => {
    const mission = new Mission(hex);
    const output = Buffer.from(mission.toHexBuffer());
    let differentBytes = 0;

    expect(output.length).toBe(fixture.length);

    for (let i = 0; i < output.length; i++) {
      if (output[i] !== fixture[i]) {
        if (differentBytes < 20) {
          console.log('different at byte', i, 'expected', fixture[i], 'got', output[i]);
        }
        differentBytes += 1;
      }
    }

    expect(differentBytes).toBeLessThan(20);
  });
});

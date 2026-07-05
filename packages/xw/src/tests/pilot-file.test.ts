import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

import { PilotFile } from '../pilot-file';

const fixturePath = resolve(__dirname, '../../../../fixtures/VANGUARD717.PLT');

function toArrayBuffer(buffer: Buffer): ArrayBuffer {
  return buffer.buffer.slice(
    buffer.byteOffset,
    buffer.byteOffset + buffer.byteLength
  ) as ArrayBuffer;
}

function countDifferentBytes(output: Buffer, input: Buffer): number {
  let differentBytes = 0;

  for (const [i, element] of output.entries()) {
    if (element === input[i]) {
    	continue;
    }

    console.log(`Byte ${i} differs: output=${element} input=${input[i]}`);
    differentBytes += 1;
  }

  return differentBytes;
}

describe('PilotFile', () => {
  const fixture = readFileSync(fixturePath);
  const hex = toArrayBuffer(fixture);

  it('parses VANGUARD717.PLT', () => {
    const pilot = new PilotFile(hex);

    expect(pilot.XWingHistoricalScore).toHaveLength(6);
    expect(pilot.Tour4Scores).toHaveLength(24);
    expect(pilot.Tour5Scores).toHaveLength(24);
    expect(pilot.TotalTODScore).toBeGreaterThan(0);
    expect(pilot.CurrentTour).toBe(4);
    expect(pilot.CurrentTourOpsComplete).toBe(20);
    expect(pilot.Unknown1).toBe(5938);
  });

  it('outputs VANGUARD717.PLT', () => {
    const pilot = new PilotFile(hex);
    const output = Buffer.from(pilot.toHexBuffer());
    const differentBytes = countDifferentBytes(output, fixture);

    expect(output.length).toBe(fixture.length);
    expect(differentBytes).toBe(0);
  });
});

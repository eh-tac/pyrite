import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

import { CraftType } from '../constants';
import { Mission } from '../mission';
import { ObjectGroup } from '../object-group';

const fixturePath = resolve(__dirname, '../../../../fixtures/xw/XWVMTC1M1.XWI');

function toArrayBuffer(buffer: Buffer): ArrayBuffer {
  return buffer.buffer.slice(
    buffer.byteOffset,
    buffer.byteOffset + buffer.byteLength
  ) as ArrayBuffer;
}

function countDifferentBytes(output: Buffer, input: Buffer): number {
  let differentBytes = 0;

  for (const [i, element] of output.entries()) {
    if (element !== input[i]) {
      differentBytes += 1;
    }
  }

  return differentBytes;
}

describe('ObjectGroup', () => {
  const fixture = readFileSync(fixturePath);
  const hex = toArrayBuffer(fixture);
  const mission = new Mission(hex);
  const objectGroupOffset =
    0xce + mission.FlightGroups.reduce((sum, group) => sum + group.getLength(), 0);

  it('parses XWVMTC1M1.XWI object groups', () => {
    expect(mission.ObjectGroups.length).toBeGreaterThan(0);

    const reference = mission.ObjectGroups[0];

    expect(reference.Name).toBe('NR-SSF#5,-6.5,-1');
    expect(reference.CraftType).toBe(CraftType.navBuoy);
    expect(reference.NumberOfCraft).toBe(1);
  });

  it('output matches the input file', () => {
    const objectGroup = new ObjectGroup(hex.slice(objectGroupOffset));
    const output = Buffer.from(objectGroup.toHexBuffer());
    const input = fixture.subarray(objectGroupOffset, objectGroupOffset + objectGroup.getLength());
    const differentBytes = countDifferentBytes(output, input);

    expect(output.length).toBe(input.length);
    expect(differentBytes).toBe(0);
  });
});

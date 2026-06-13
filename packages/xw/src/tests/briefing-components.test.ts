import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';
import { Briefing } from '../briefing';
import { BriefingHeader } from '../briefing-header';
import { Coordinate } from '../coordinate';
import { Icon } from '../icon';
import { MissionHeader } from '../mission-header';
import { Page } from '../page';
import { String as XwString } from '../string';
import { Tag } from '../tag';
import { ViewportSetting } from '../viewport-setting';

const fixturePath = resolve(__dirname, '../../../../fixtures/xw/XWVMTC1M1.BRF');

function toArrayBuffer(buffer: Buffer): ArrayBuffer {
  return buffer.buffer.slice(
    buffer.byteOffset,
    buffer.byteOffset + buffer.byteLength
  ) as ArrayBuffer;
}

function countDifferentBytes(output: Buffer, input: Buffer): number {
  let differentBytes = 0;

  for (let i = 0; i < output.length; i++) {
    if (output[i] !== input[i]) {
      differentBytes += 1;
    }
  }

  return differentBytes;
}

describe('Briefing component classes', () => {
  const fixture = readFileSync(fixturePath);
  const hex = toArrayBuffer(fixture);
  const briefing = new Briefing(hex);

  const coordinateOffset = 0x6;
  const iconOffset =
    coordinateOffset +
    briefing.CoordinateSet.reduce((sum, coordinate) => sum + coordinate.getLength(), 0);
  const viewportCountOffset =
    iconOffset + briefing.IconSet.reduce((sum, icon) => sum + icon.getLength(), 0);
  const viewportOffset = viewportCountOffset + 2;
  const pageCountOffset =
    viewportOffset + briefing.Viewports.reduce((sum, viewport) => sum + viewport.getLength(), 0);
  const pageOffset = pageCountOffset + 2;
  const missionHeaderOffset =
    pageOffset + briefing.Pages.reduce((sum, page) => sum + page.getLength(), 0);
  const iconExtraOffset = missionHeaderOffset + briefing.MissionHeader.getLength();
  const tagOffset = iconExtraOffset + briefing.BriefingHeader.IconCount * 90;
  const stringOffset = tagOffset + briefing.Tags.getLength();

  function expectRoundTrip(
    offset: number,
    length: number,
    output: ArrayBuffer,
    tolerance = 0
  ): void {
    const input = fixture.subarray(offset, offset + length);
    const differentBytes = countDifferentBytes(Buffer.from(output), input);

    expect(differentBytes).toBeLessThanOrEqual(tolerance);
  }

  it('parses and outputs BriefingHeader', () => {
    const header = new BriefingHeader(hex.slice(0x00));

    expect(header.PlatformID).toBe(briefing.BriefingHeader.PlatformID);
    expect(header.IconCount).toBe(16);
    expect(header.CoordinateCount).toBe(2);

    expectRoundTrip(0x00, header.getLength(), header.toHexBuffer());
  });

  it('parses and outputs Coordinate', () => {
    const coordinate = new Coordinate(hex.slice(coordinateOffset));
    const reference = briefing.CoordinateSet[0];

    expect(coordinate.X).toBe(reference.X);
    expect(coordinate.Y).toBe(reference.Y);
    expect(coordinate.Z).toBe(reference.Z);

    expectRoundTrip(coordinateOffset, coordinate.getLength(), coordinate.toHexBuffer());
  });

  it('parses and outputs Icon', () => {
    const icon = new Icon(hex.slice(iconOffset));
    const reference = briefing.IconSet[0];

    expect(icon.Name).toBe(reference.Name);
    expect(icon.CraftType).toBe(reference.CraftType);
    expect(icon.NumberOfCraft).toBe(reference.NumberOfCraft);

    expectRoundTrip(iconOffset, icon.getLength(), icon.toHexBuffer());
  });

  it('parses and outputs ViewportSetting', () => {
    const viewport = new ViewportSetting(hex.slice(viewportOffset));
    const reference = briefing.Viewports[0];

    expect(viewport.Top).toBe(reference.Top);
    expect(viewport.Left).toBe(reference.Left);
    expect(viewport.Visible).toBe(reference.Visible);

    expectRoundTrip(viewportOffset, viewport.getLength(), viewport.toHexBuffer());
  });

  it('parses and outputs Page', () => {
    expect(briefing.Pages.length).toBeGreaterThan(0);

    const page = new Page(hex.slice(pageOffset));
    const reference = briefing.Pages[0];

    expect(page.Duration).toBe(reference.Duration);
    expect(page.EventsLength).toBe(reference.EventsLength);
    expect(page.CoordinateSet).toBe(reference.CoordinateSet);
    expect(page.PageType).toBe(reference.PageType);
    expect(page.Events).toEqual(reference.Events);

    expectRoundTrip(pageOffset, page.getLength(), page.toHexBuffer());
  });

  it('parses and outputs MissionHeader', () => {
    const input = Buffer.from(briefing.MissionHeader.toHexBuffer());
    const missionHeader = new MissionHeader(toArrayBuffer(input));
    const reference = briefing.MissionHeader;

    expect(missionHeader.TimeLimitMinutes).toBe(reference.TimeLimitMinutes);
    expect(missionHeader.EndEvent).toBe(reference.EndEvent);
    expect(missionHeader.EndOfMissionMessages).toEqual(reference.EndOfMissionMessages);

    expect(countDifferentBytes(Buffer.from(missionHeader.toHexBuffer()), input)).toBe(0);
  });

  it('parses and outputs Tag', () => {
    const tag = new Tag(hex.slice(tagOffset));

    expect(tag.Length).toBe(briefing.Tags.Length);
    expect(tag.Unnamed.slice(0, 10)).toEqual(briefing.Tags.Unnamed.slice(0, 10));

    expectRoundTrip(tagOffset, tag.getLength(), tag.toHexBuffer());
  });

  it('parses and outputs String', () => {
    const strings = new XwString(hex.slice(stringOffset));

    expect(strings.Length).toBe(briefing.Strings.Length);
    expect(strings.String.slice(0, 20)).toEqual(briefing.Strings.String.slice(0, 20));
    expect(strings.Highlight.slice(0, 20)).toEqual(briefing.Strings.Highlight.slice(0, 20));

    expectRoundTrip(stringOffset, strings.getLength(), strings.toHexBuffer());
  });
});

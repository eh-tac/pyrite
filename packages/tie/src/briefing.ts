import { getInt, getShort } from '@pyrite/core';
import type { IMission } from '@pyrite/core';
import { BriefingBase } from './base/briefing-base';
import { EventType } from './constants';
import { Event } from './event';
import { Tag } from './tag';
import { TIEString } from './tie-string';
import { Mission } from './mission';

export class Briefing extends BriefingBase {
  public constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE);
    let offset = 0;
    this.RunningTime = getShort(hex, 0x000);
    this.Unknown = getShort(hex, 0x002);
    this.StartLength = getShort(hex, 0x004);
    this.EventsLength = getInt(hex, 0x006);

    this.Events = [];
    offset = 0x00a;
    let eventParsed = 0;
    while (eventParsed < this.EventsLength * 2) {
      const t = new Event(hex.slice(offset), this.TIE as Mission);
      t.Briefing = this;
      this.Events.push(t);
      offset += t.getLength();
      eventParsed += t.getLength();
    }

    this.Tags = [];
    offset = 0x32a;
    for (let i = 0; i < 32; i++) {
      const t = new Tag(hex.slice(offset), this.TIE as Mission);
      this.Tags.push(t);
      offset += t.getLength();
    }

    this.Strings = [];
    for (let i = 0; i < 32; i++) {
      const t = new TIEString(hex.slice(offset), this.TIE as Mission);
      this.Strings.push(t);
      offset += t.getLength();
    }
    this.BriefingLength = offset;
  }

  public get Captions(): string[] {
    return this.Events.filter((e) => e.EventType === EventType.captionText).map((e) => e.Text);
  }
}

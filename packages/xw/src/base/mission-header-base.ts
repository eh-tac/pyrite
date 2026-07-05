import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getChar, getShort, writeChar, writeShort } from '@pyrite/core';

import type { EndEvent, MissionLocation } from '../constants';
import { Constants } from '../constants';
export abstract class MissionHeaderBase extends PyriteBase implements Byteable {
  public readonly MISSIONHEADERLENGTH: number = 200;
  public TimeLimitMinutes: number;
  public EndEvent: EndEvent;
  public RndSeed: number; //(unused)
  public MissionLocation: MissionLocation;
  public EndOfMissionMessages: string[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.TimeLimitMinutes = getShort(hex, 0x00);
    this.EndEvent = getShort(hex, 0x02) as EndEvent;
    this.RndSeed = getShort(hex, 0x04);
    this.MissionLocation = getShort(hex, 0x06) as MissionLocation;
    this.EndOfMissionMessages = [];
    offset = 0x08;
    for (let i = 0; i < 3; i++) {
      const t = getChar(hex, offset, 16);
      this.EndOfMissionMessages.push(t);
      offset += 16;
    }
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      TimeLimitMinutes: this.TimeLimitMinutes,
      EndEvent: this.EndEventLabel,
      RndSeed: this.RndSeed,
      MissionLocation: this.MissionLocationLabel,
      EndOfMissionMessages: this.EndOfMissionMessages
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.TimeLimitMinutes, 0x00);
    writeShort(hex, this.EndEvent, 0x02);
    writeShort(hex, this.RndSeed, 0x04);
    writeShort(hex, this.MissionLocation, 0x06);
    offset = 0x08;
    for (let i = 0; i < this.EndOfMissionMessages.length; i++) {
      const t = this.EndOfMissionMessages[i];
      writeChar(hex, t, offset, 16);
      offset += 16;
    }

    return hex;
  }

  public get EndEventLabel(): string {
    return Constants.ENDEVENT[this.EndEvent] || 'Unknown';
  }

  public get MissionLocationLabel(): string {
    return Constants.MISSIONLOCATION[this.MissionLocation] || 'Unknown';
  }

  public getLength(): number {
    return this.MISSIONHEADERLENGTH;
  }
}

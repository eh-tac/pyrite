import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getShort, getString, writeShort, writeString } from '@pyrite/core';

import type { EndEvent, MissionLocation } from '../constants';
import { Constants } from '../constants';
export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public readonly FILEHEADERLENGTH: number = 206;
  public Version: number;
  public TimeLimit: number; //in minutes
  public EndEvent: EndEvent;
  public readonly Reserved: number = 0;
  public MissionLocation: MissionLocation;
  public CompletionMessage: string[];
  public NumFGs: number;
  public NumObj: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Version = getShort(hex, 0x00);
    this.TimeLimit = getShort(hex, 0x02);
    this.EndEvent = getShort(hex, 0x04) as EndEvent;
    // static prop Reserved
    this.MissionLocation = getShort(hex, 0x08) as MissionLocation;
    this.CompletionMessage = [];
    offset = 0x0a;
    for (let i = 0; i < 3; i++) {
      const t = getString(hex, offset, 64);
      this.CompletionMessage.push(t);
      offset += 64;
    }
    this.NumFGs = getShort(hex, 0xca);
    this.NumObj = getShort(hex, 0xcc);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Version: this.Version,
      TimeLimit: this.TimeLimit,
      EndEvent: this.EndEventLabel,
      MissionLocation: this.MissionLocationLabel,
      CompletionMessage: this.CompletionMessage,
      NumFGs: this.NumFGs,
      NumObj: this.NumObj
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Version, 0x00);
    writeShort(hex, this.TimeLimit, 0x02);
    writeShort(hex, this.EndEvent, 0x04);
    writeShort(hex, this.Reserved, 0x06);
    writeShort(hex, this.MissionLocation, 0x08);
    offset = 0x0a;
    for (let i = 0; i < this.CompletionMessage.length; i++) {
      const t = this.CompletionMessage[i];
      writeString(hex, t, offset, 64);
      offset += 64;
    }
    writeShort(hex, this.NumFGs, 0xca);
    writeShort(hex, this.NumObj, 0xcc);

    return hex;
  }

  public get EndEventLabel(): string {
    return Constants.ENDEVENT[this.EndEvent] || 'Unknown';
  }

  public get MissionLocationLabel(): string {
    return Constants.MISSIONLOCATION[this.MissionLocation] || 'Unknown';
  }

  public getLength(): number {
    return this.FILEHEADERLENGTH;
  }
}

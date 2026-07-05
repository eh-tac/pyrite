import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import {
  getByte,
  getChar,
  getShort,
  getString,
  writeByte,
  writeChar,
  writeShort,
  writeString
} from '@pyrite/core';
export abstract class TeamBase extends PyriteBase implements Byteable {
  public readonly TEAMLENGTH: number = 487;
  public Reserved: number; //(1)
  public Name: string;
  public Allegiances: number[];
  public EndOfMissionMessages: string[];
  public EomMessageDelay: number[]; //(was Unknowns)
  public EomSourceFG: number[]; //(was Unknowns)
  public EomVoiceIDs: string[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Reserved = getShort(hex, 0x000);
    this.Name = getString(hex, 0x002, 16);
    this.Allegiances = [];
    offset = 0x01a;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.Allegiances.push(t);
      offset += 1;
    }
    this.EndOfMissionMessages = [];
    offset = 0x024;
    for (let i = 0; i < 6; i++) {
      const t = getChar(hex, offset, 64);
      this.EndOfMissionMessages.push(t);
      offset += 64;
    }
    this.EomMessageDelay = [];
    offset = 0x1a4;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.EomMessageDelay.push(t);
      offset += 1;
    }
    this.EomSourceFG = [];
    offset = 0x1a7;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.EomSourceFG.push(t);
      offset += 1;
    }
    this.EomVoiceIDs = [];
    offset = 0x1aa;
    for (let i = 0; i < 3; i++) {
      const t = getChar(hex, offset, 20);
      this.EomVoiceIDs.push(t);
      offset += 20;
    }
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Reserved: this.Reserved,
      Name: this.Name,
      Allegiances: this.Allegiances,
      EndOfMissionMessages: this.EndOfMissionMessages,
      EomMessageDelay: this.EomMessageDelay,
      EomSourceFG: this.EomSourceFG,
      EomVoiceIDs: this.EomVoiceIDs
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Reserved, 0x000);
    writeString(hex, this.Name, 0x002, 16);
    offset = 0x01a;
    for (let i = 0; i < this.Allegiances.length; i++) {
      const t = this.Allegiances[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x024;
    for (let i = 0; i < this.EndOfMissionMessages.length; i++) {
      const t = this.EndOfMissionMessages[i];
      writeChar(hex, t, offset, 64);
      offset += 64;
    }
    offset = 0x1a4;
    for (let i = 0; i < this.EomMessageDelay.length; i++) {
      const t = this.EomMessageDelay[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x1a7;
    for (let i = 0; i < this.EomSourceFG.length; i++) {
      const t = this.EomSourceFG[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x1aa;
    for (let i = 0; i < this.EomVoiceIDs.length; i++) {
      const t = this.EomVoiceIDs[i];
      writeChar(hex, t, offset, 20);
      offset += 20;
    }

    return hex;
  }

  public getLength(): number {
    return this.TEAMLENGTH;
  }
}

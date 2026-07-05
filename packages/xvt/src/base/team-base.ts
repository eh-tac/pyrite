import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import {
  getBool,
  getChar,
  getShort,
  getString,
  writeBool,
  writeChar,
  writeShort,
  writeString
} from '@pyrite/core';
export abstract class TeamBase extends PyriteBase implements Byteable {
  public readonly TEAMLENGTH: number = 487;
  public Reserved: number; //(1)
  public Name: string;
  public Allegiances: boolean[];
  public EndOfMissionMessages: string[];

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Reserved = getShort(hex, 0x000);
    this.Name = getString(hex, 0x002, 16);
    this.Allegiances = [];
    offset = 0x01a;
    for (let i = 0; i < 10; i++) {
      const t = getBool(hex, offset);
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
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Reserved: this.Reserved,
      Name: this.Name,
      Allegiances: this.Allegiances,
      EndOfMissionMessages: this.EndOfMissionMessages
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
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x024;
    for (let i = 0; i < this.EndOfMissionMessages.length; i++) {
      const t = this.EndOfMissionMessages[i];
      writeChar(hex, t, offset, 64);
      offset += 64;
    }

    return hex;
  }

  public getLength(): number {
    return this.TEAMLENGTH;
  }
}

import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, getChar, getShort, getString, writeByte, writeChar, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TeamBase extends PyriteBase implements Byteable {
  public readonly TEAMLENGTH: number = 487;
  public Reserved: number; //(1)
  public Name: string;
  public Allegiances: number[];
  public EndOfMissionMessages: string[];
  public Unknowns: number[];
  public EomVoiceIDs: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Reserved = getShort(hex, 0x000);
    this.Name = getString(hex, 0x002, 18);
    this.Allegiances = [];
    offset = 0x01A;
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
    this.Unknowns = [];
    offset = 0x1A4;
    for (let i = 0; i < 6; i++) {
      const t = getByte(hex, offset);
      this.Unknowns.push(t);
      offset += 1;
    }
    this.EomVoiceIDs = [];
    offset = 0x1AA;
    for (let i = 0; i < 3; i++) {
      const t = getChar(hex, offset, 20);
      this.EomVoiceIDs.push(t);
      offset += 20;
    }
    
  }
  
  public toJSON(): object {
    return {
      Reserved: this.Reserved,
      Name: this.Name,
      Allegiances: this.Allegiances,
      EndOfMissionMessages: this.EndOfMissionMessages,
      Unknowns: this.Unknowns,
      EomVoiceIDs: this.EomVoiceIDs
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Reserved, 0x000);
    writeString(hex, this.Name, 0x002);
    offset = 0x01A;
    for (let i = 0; i < 10; i++) {
      const t = this.Allegiances[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x024;
    for (let i = 0; i < 6; i++) {
      const t = this.EndOfMissionMessages[i];
      writeChar(hex, t, offset);
      offset += 64;
    }
    offset = 0x1A4;
    for (let i = 0; i < 6; i++) {
      const t = this.Unknowns[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x1AA;
    for (let i = 0; i < 3; i++) {
      const t = this.EomVoiceIDs[i];
      writeChar(hex, t, offset);
      offset += 20;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.TEAMLENGTH;
  }
}
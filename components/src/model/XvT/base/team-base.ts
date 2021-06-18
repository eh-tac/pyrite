import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getBool, getChar, getShort, getString, writeBool, writeChar, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TeamBase extends PyriteBase implements Byteable {
  public readonly TEAMLENGTH: number = 487;
  public Reserved: number; //(1)
  public Name: string;
  public Allegiances: boolean[];
  public EndOfMissionMessages: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Reserved = getShort(hex, 0x000);
    this.Name = getString(hex, 0x002, 16);
    this.Allegiances = [];
    offset = 0x01A;
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
  
  public toJSON(): object {
    return {
      Reserved: this.Reserved,
      Name: this.Name,
      Allegiances: this.Allegiances,
      EndOfMissionMessages: this.EndOfMissionMessages
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
      writeBool(hex, t, offset);
      offset += 1;
    }
    offset = 0x024;
    for (let i = 0; i < 6; i++) {
      const t = this.EndOfMissionMessages[i];
      writeChar(hex, t, offset);
      offset += 64;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.TEAMLENGTH;
  }
}
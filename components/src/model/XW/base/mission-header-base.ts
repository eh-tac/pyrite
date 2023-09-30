import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getShort, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionHeaderBase extends PyriteBase implements Byteable {
  public readonly MISSIONHEADERLENGTH: number = 200;
  public TimeLimitMinutes: number;
  public EndEvent: number;
  public RndSeed: number; //(unused)
  public Location: number;
  public EndOfMissionMessages: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.TimeLimitMinutes = getShort(hex, 0x00);
    this.EndEvent = getShort(hex, 0x02);
    this.RndSeed = getShort(hex, 0x04);
    this.Location = getShort(hex, 0x06);
    this.EndOfMissionMessages = [];
    offset = 0x08;
    for (let i = 0; i < 64; i++) {
      const t = getChar(hex, offset, 1);
      this.EndOfMissionMessages.push(t);
      offset += 1;
    }
    
  }
  
  public toJSON(): object {
    return {
      TimeLimitMinutes: this.TimeLimitMinutes,
      EndEvent: this.EndEventLabel,
      RndSeed: this.RndSeed,
      Location: this.LocationLabel,
      EndOfMissionMessages: this.EndOfMissionMessages
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.TimeLimitMinutes, 0x00);
    writeShort(hex, this.EndEvent, 0x02);
    writeShort(hex, this.RndSeed, 0x04);
    writeShort(hex, this.Location, 0x06);
    offset = 0x08;
    for (let i = 0; i < 64; i++) {
      const t = this.EndOfMissionMessages[i];
      writeChar(hex, t, offset);
      offset += 1;
    }

    return hex;
  }
  
  public get EndEventLabel(): string {
    return Constants.ENDEVENT[this.EndEvent] || "Unknown";
  }

  public get LocationLabel(): string {
    return Constants.LOCATION[this.Location] || "Unknown";
  }
  
  public getLength(): number {
    return this.MISSIONHEADERLENGTH;
  }
}
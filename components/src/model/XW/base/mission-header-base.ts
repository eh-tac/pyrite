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
  public MissionLocation: number;
  public EndOfMissionMessages: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.TimeLimitMinutes = getShort(hex, 0x00);
    this.EndEvent = getShort(hex, 0x02);
    this.RndSeed = getShort(hex, 0x04);
    this.MissionLocation = getShort(hex, 0x06);
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
      MissionLocation: this.MissionLocationLabel,
      EndOfMissionMessages: this.EndOfMissionMessages
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.TimeLimitMinutes, 0x00);
    writeShort(hex, this.EndEvent, 0x02);
    writeShort(hex, this.RndSeed, 0x04);
    writeShort(hex, this.MissionLocation, 0x06);
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

  public get MissionLocationLabel(): string {
    return Constants.MISSIONLOCATION[this.MissionLocation] || "Unknown";
  }
  
  public getLength(): number {
    return this.MISSIONHEADERLENGTH;
  }
}
import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, getString, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public readonly FILEHEADERLENGTH: number = 206;
  public Version: number;
  public TimeLimit: number; //in minutes
  public EndState: number;
  public readonly Reserved: number = 0;
  public MissionLocation: number;
  public CompletionMessage: string[];
  public NumFGs: number;
  public NumObj: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Version = getShort(hex, 0x00);
    this.TimeLimit = getShort(hex, 0x02);
    this.EndState = getShort(hex, 0x04);
    // static prop Reserved
    this.MissionLocation = getShort(hex, 0x08);
    this.CompletionMessage = [];
    offset = 0x0A;
    for (let i = 0; i < 3; i++) {
      const t = getString(hex, offset);
      this.CompletionMessage.push(t);
      offset += t.length + 1;
    }
    this.NumFGs = getShort(hex, 0xCA);
    this.NumObj = getShort(hex, 0xCC);
    
  }
  
  public toJSON(): object {
    return {
      Version: this.Version,
      TimeLimit: this.TimeLimit,
      EndState: this.EndStateLabel,
      MissionLocation: this.MissionLocationLabel,
      CompletionMessage: this.CompletionMessage,
      NumFGs: this.NumFGs,
      NumObj: this.NumObj
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Version, 0x00);
    writeShort(hex, this.TimeLimit, 0x02);
    writeShort(hex, this.EndState, 0x04);
    writeShort(hex, 0, 0x06);
    writeShort(hex, this.MissionLocation, 0x08);
    offset = 0x0A;
    for (let i = 0; i < 3; i++) {
      const t = this.CompletionMessage[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }
    writeShort(hex, this.NumFGs, 0xCA);
    writeShort(hex, this.NumObj, 0xCC);

    return hex;
  }
  
  public get EndStateLabel(): string {
    return Constants.ENDSTATE[this.EndState] || "Unknown";
  }

  public get MissionLocationLabel(): string {
    return Constants.MISSIONLOCATION[this.MissionLocation] || "Unknown";
  }
  
  public getLength(): number {
    return this.FILEHEADERLENGTH;
  }
}
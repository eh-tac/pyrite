import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { LengthString } from "../length-string";
import { getBool, getInt, getShort, writeBool, writeInt, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BriefingBase extends PyriteBase implements Byteable {
  public BriefingLength: number;
  public RunningTime: number;
  public Unknown1: number;
  public StartLength: number;
  public EventsLength: number;
  public Unnamed: LengthString[];
  public ShowToTeams: boolean[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.RunningTime = getShort(hex, 0x0000);
    this.Unknown1 = getShort(hex, 0x0002);
    this.StartLength = getShort(hex, 0x0004);
    this.EventsLength = getInt(hex, 0x0006);
    this.Unnamed = [];
    offset = offset;
    for (let i = 0; i < 128; i++) {
      const t = new LengthString(hex.slice(offset), this.TIE);
      this.Unnamed.push(t);
      offset += t.getLength();
    }
    this.ShowToTeams = [];
    offset = 0x440A;
    for (let i = 0; i < 10; i++) {
      const t = getBool(hex, offset);
      this.ShowToTeams.push(t);
      offset += 1;
    }
    this.BriefingLength = offset;
  }
  
  public toJSON(): object {
    return {
      RunningTime: this.RunningTime,
      Unknown1: this.Unknown1,
      StartLength: this.StartLength,
      EventsLength: this.EventsLength,
      Unnamed: this.Unnamed,
      ShowToTeams: this.ShowToTeams
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.RunningTime, 0x0000);
    writeShort(hex, this.Unknown1, 0x0002);
    writeShort(hex, this.StartLength, 0x0004);
    writeInt(hex, this.EventsLength, 0x0006);
    offset = offset;
    for (let i = 0; i < 128; i++) {
      const t = this.Unnamed[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x440A;
    for (let i = 0; i < 10; i++) {
      const t = this.ShowToTeams[i];
      writeBool(hex, t, offset);
      offset += 1;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.BriefingLength;
  }
}
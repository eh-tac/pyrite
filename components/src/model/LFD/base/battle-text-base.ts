import { Byteable } from "../../../byteable";
import { Header } from "../header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { LString } from "../l-string";
import { getShort, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BattleTextBase extends PyriteBase implements Byteable {
  public BattleTextLength: number;
  public Header: Header;
  public NumStrings: number;
  public Names: LString;
  public Titles: LString;
  public Image: LString;
  public MissionFiles: LString;
  public MissionDescriptions: LString[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Header = new Header(hex.slice(0x00), this.TIE);
    this.NumStrings = getShort(hex, 0x10);
    this.Names = new LString(hex.slice(0x12), this.TIE);
    offset = 0x12 + this.Names.getLength()
    this.Titles = new LString(hex.slice(offset), this.TIE);
    offset += this.Titles.getLength()
    this.Image = new LString(hex.slice(offset), this.TIE);
    offset += this.Image.getLength()
    this.MissionFiles = new LString(hex.slice(offset), this.TIE);
    offset += this.MissionFiles.getLength()
    this.MissionDescriptions = [];
    offset = offset;
    for (let i = 0; i < this.NumMissions(); i++) {
      const t = new LString(hex.slice(offset), this.TIE);
      this.MissionDescriptions.push(t);
      offset += t.getLength();
    }
    this.BattleTextLength = offset;
  }
  
  public toJSON(): object {
    return {
      Header: this.Header,
      NumStrings: this.NumStrings,
      Names: this.Names,
      Titles: this.Titles,
      Image: this.Image,
      MissionFiles: this.MissionFiles,
      MissionDescriptions: this.MissionDescriptions
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.Header, 0x00);
    writeShort(hex, this.NumStrings, 0x10);
    writeObject(hex, this.Names, 0x12);
    writeObject(hex, this.Titles, offset);
    writeObject(hex, this.Image, offset);
    writeObject(hex, this.MissionFiles, offset);
    offset = offset;
    for (let i = 0; i < this.NumMissions(); i++) {
      const t = this.MissionDescriptions[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  protected abstract NumMissions();
  public getLength(): number {
    return this.BattleTextLength;
  }
}
import { Byteable } from "../../../byteable";
import { Header } from "../header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { VoicData } from "../voic-data";
import { getByte, getChar, writeByte, writeChar, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class VoicBase extends PyriteBase implements Byteable {
  public VoicLength: number;
  public Header: Header;
  public Creative: string;
  public Abort: number[];
  public Version: number[];
  public VersionHash: number[];
  public Data: VoicData;
  public Terminator: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Header = new Header(hex.slice(0x00), this.TIE);
    this.Creative = getChar(hex, 0x10, 19);
    this.Abort = [];
    offset = 0x23;
    for (let i = 0; i < 3; i++) {
      const t = getByte(hex, offset);
      this.Abort.push(t);
      offset += 1;
    }
    this.Version = [];
    offset = 0x26;
    for (let i = 0; i < 2; i++) {
      const t = getByte(hex, offset);
      this.Version.push(t);
      offset += 1;
    }
    this.VersionHash = [];
    offset = 0x28;
    for (let i = 0; i < 2; i++) {
      const t = getByte(hex, offset);
      this.VersionHash.push(t);
      offset += 1;
    }
    this.Data = new VoicData(hex.slice(0x2A), this.TIE);
    offset = 0x2A + this.Data.getLength();
    this.Terminator = getByte(hex, offset);
    this.VoicLength = offset;
  }
  
  public toJSON(): object {
    return {
      Header: this.Header,
      Creative: this.Creative,
      Abort: this.Abort,
      Version: this.Version,
      VersionHash: this.VersionHash,
      Data: this.Data,
      Terminator: this.Terminator
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.Header, 0x00);
    writeChar(hex, this.Creative, 0x10);
    offset = 0x23;
    for (let i = 0; i < 3; i++) {
      const t = this.Abort[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x26;
    for (let i = 0; i < 2; i++) {
      const t = this.Version[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x28;
    for (let i = 0; i < 2; i++) {
      const t = this.VersionHash[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeObject(hex, this.Data, 0x2A);
    writeByte(hex, this.Terminator, offset);

    return hex;
  }
  
  
  public getLength(): number {
    return this.VoicLength;
  }
}
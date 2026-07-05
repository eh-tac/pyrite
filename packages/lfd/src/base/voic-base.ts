import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { Header } from '../header';
import { VoicData } from '../voic-data';
import { getByte, getChar, writeByte, writeChar, writeObject } from '@pyrite/core';
export abstract class VoicBase extends PyriteBase implements Byteable {
  public VoicLength: number;
  public Header: Header;
  public Creative: string;
  public Abort: number[];
  public Version: number[];
  public VersionHash: number[];
  public Data: VoicData;
  public Terminator: number;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
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
    this.Data = new VoicData(hex.slice(0x2a), this.TIE);
    offset = 0x2a + this.Data.getLength();
    this.Terminator = getByte(hex, offset);
    offset += 1;
    this.VoicLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Header: this.Header.toJSON(),
      Creative: this.Creative,
      Abort: this.Abort,
      Version: this.Version,
      VersionHash: this.VersionHash,
      Data: this.Data.toJSON(),
      Terminator: this.Terminator
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.Header, 0x00);
    writeChar(hex, this.Creative, 0x10, 19);
    offset = 0x23;
    for (let i = 0; i < this.Abort.length; i++) {
      const t = this.Abort[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x26;
    for (let i = 0; i < this.Version.length; i++) {
      const t = this.Version[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x28;
    for (let i = 0; i < this.VersionHash.length; i++) {
      const t = this.VersionHash[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeObject(hex, this.Data, 0x2a);
    writeByte(hex, this.Terminator, offset);
    offset += 1;

    return hex;
  }

  public getLength(): number {
    return this.VoicLength;
  }
}

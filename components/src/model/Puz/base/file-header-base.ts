import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public readonly FILEHEADERLENGTH: number = 52;
  public FileChecksum: number;
  public Descriptor: string;
  public BaseChecksum: number;
  public MaskedChecksums: number[];
  public Version: string;
  public Unused: number;
  public Unknown: number;
  public Reserved: string;
  public Width: number;
  public Height: number;
  public NumClues: number;
  public Bitmask1: number;
  public Bitmask2: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.FileChecksum = getShort(hex, 0x00);
    this.Descriptor = getChar(hex, 0x02, 12);
    this.BaseChecksum = getShort(hex, 0x0E);
    this.MaskedChecksums = [];
    offset = 0x10;
    for (let i = 0; i < 4; i++) {
      const t = getShort(hex, offset);
      this.MaskedChecksums.push(t);
      offset += 2;
    }
    this.Version = getChar(hex, 0x18, 4);
    this.Unused = getShort(hex, 0x1C);
    this.Unknown = getShort(hex, 0x1E);
    this.Reserved = getChar(hex, 0x20, 12);
    this.Width = getByte(hex, 0x2C);
    this.Height = getByte(hex, 0x2D);
    this.NumClues = getShort(hex, 0x2E);
    this.Bitmask1 = getShort(hex, 0x30);
    this.Bitmask2 = getShort(hex, 0x32);
    
  }
  
  public toJSON(): object {
    return {
      FileChecksum: this.FileChecksum,
      Descriptor: this.Descriptor,
      BaseChecksum: this.BaseChecksum,
      MaskedChecksums: this.MaskedChecksums,
      Version: this.Version,
      Unused: this.Unused,
      Unknown: this.Unknown,
      Reserved: this.Reserved,
      Width: this.Width,
      Height: this.Height,
      NumClues: this.NumClues,
      Bitmask1: this.Bitmask1,
      Bitmask2: this.Bitmask2
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.FileChecksum, 0x00);
    writeChar(hex, this.Descriptor, 0x02);
    writeShort(hex, this.BaseChecksum, 0x0E);
    offset = 0x10;
    for (let i = 0; i < 4; i++) {
      const t = this.MaskedChecksums[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    writeChar(hex, this.Version, 0x18);
    writeShort(hex, this.Unused, 0x1C);
    writeShort(hex, this.Unknown, 0x1E);
    writeChar(hex, this.Reserved, 0x20);
    writeByte(hex, this.Width, 0x2C);
    writeByte(hex, this.Height, 0x2D);
    writeShort(hex, this.NumClues, 0x2E);
    writeShort(hex, this.Bitmask1, 0x30);
    writeShort(hex, this.Bitmask2, 0x32);

    return hex;
  }
  
  
  public getLength(): number {
    return this.FILEHEADERLENGTH;
  }
}
import { Byteable } from "../../../byteable";
import { FileHeader } from "../file-header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, getString, writeChar, writeObject, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class CrosswordBase extends PyriteBase implements Byteable {
  public CrosswordLength: number;
  public FileHeader: FileHeader;
  public SolutionGrid: string;
  public ProgressGrid: string;
  public Title: string;
  public Author: string;
  public Copyright: string;
  public Clues: string[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x00), this.TIE);
    this.SolutionGrid = getChar(hex, 0x34, this.GridSize());
    offset = 0x34 + this.GridSize();
    this.ProgressGrid = getChar(hex, offset, this.GridSize());
    offset += this.GridSize();
    this.Title = getString(hex, offset);
    offset += this.Title.length + 1;
    this.Author = getString(hex, offset);
    offset += this.Author.length + 1;
    this.Copyright = getString(hex, offset);
    offset += this.Copyright.length + 1;
    this.Clues = [];
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumClues; i++) {
      const t = getString(hex, offset);
      this.Clues.push(t);
      offset += t.length + 1;
    }
    this.CrosswordLength = offset;
  }
  
  public toJSON(): object {
    return {
      FileHeader: this.FileHeader,
      SolutionGrid: this.SolutionGrid,
      ProgressGrid: this.ProgressGrid,
      Title: this.Title,
      Author: this.Author,
      Copyright: this.Copyright,
      Clues: this.Clues
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x00);
    writeChar(hex, this.SolutionGrid, 0x34);
    writeChar(hex, this.ProgressGrid, offset);
    writeString(hex, this.Title, offset);
    writeString(hex, this.Author, offset);
    writeString(hex, this.Copyright, offset);
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumClues; i++) {
      const t = this.Clues[i];
      writeString(hex, t, offset);
      offset += t.length + 1;
    }

    return hex;
  }
  
  protected abstract GridSize();
  public getLength(): number {
    return this.CrosswordLength;
  }
}
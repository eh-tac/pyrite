import { Byteable } from "../../../byteable";
import { FileHeader } from "../file-header";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { ObjectGroup } from "../object-group";
import { writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength: number;
  public FileHeader: FileHeader;
  public Unnamed: ObjectGroup[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x00), this.TIE);
    this.Unnamed = [];
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumObj; i++) {
      const t = new ObjectGroup(hex.slice(offset), this.TIE);
      this.Unnamed.push(t);
      offset += t.getLength();
    }
    this.MissionLength = offset;
  }
  
  public toJSON(): object {
    return {
      FileHeader: this.FileHeader,
      Unnamed: this.Unnamed
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x00);
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumObj; i++) {
      const t = this.Unnamed[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.MissionLength;
  }
}
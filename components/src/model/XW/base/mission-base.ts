import { Byteable } from "../../../byteable";
import { FileHeader } from "../file-header";
import { FlightGroup } from "../flight-group";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { ObjectGroup } from "../object-group";
import { writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength: number;
  public FileHeader: FileHeader;
  public FlightGroups: FlightGroup[];
  public ObjectGroups: ObjectGroup[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x00), this.TIE);
    this.FlightGroups = [];
    offset = 0xCE;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = new FlightGroup(hex.slice(offset), this.TIE);
      this.FlightGroups.push(t);
      offset += t.getLength();
    }
    this.ObjectGroups = [];
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumObj; i++) {
      const t = new ObjectGroup(hex.slice(offset), this.TIE);
      this.ObjectGroups.push(t);
      offset += t.getLength();
    }
    this.MissionLength = offset;
  }
  
  public toJSON(): object {
    return {
      FileHeader: this.FileHeader,
      FlightGroups: this.FlightGroups,
      ObjectGroups: this.ObjectGroups
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x00);
    offset = 0xCE;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = this.FlightGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < this.FileHeader.NumObj; i++) {
      const t = this.ObjectGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.MissionLength;
  }
}
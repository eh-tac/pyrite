import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { FileHeader } from '../file-header';
import { FlightGroup } from '../flight-group';
import { ObjectGroup } from '../object-group';
import { writeObject } from '@pyrite/core';
export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength: number;
  public FileHeader: FileHeader;
  public FlightGroups: FlightGroup[];
  public ObjectGroups: ObjectGroup[];

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.FileHeader = new FileHeader(hex.slice(0x00), this.TIE);
    this.FlightGroups = [];
    offset = 0xce;
    for (let i = 0; i < this.FileHeader.NumFGs; i++) {
      const t = new FlightGroup(hex.slice(offset), this.TIE);
      this.FlightGroups.push(t);
      offset += t.getLength();
    }
    this.ObjectGroups = [];
    for (let i = 0; i < this.FileHeader.NumObj; i++) {
      const t = new ObjectGroup(hex.slice(offset), this.TIE);
      this.ObjectGroups.push(t);
      offset += t.getLength();
    }
    this.MissionLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      FileHeader: this.FileHeader.toJSON(),
      FlightGroups: this.FlightGroups.map((t) => t.toJSON()),
      ObjectGroups: this.ObjectGroups.map((t) => t.toJSON())
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.FileHeader, 0x00);
    offset = 0xce;
    for (let i = 0; i < this.FlightGroups.length; i++) {
      const t = this.FlightGroups[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.ObjectGroups.length; i++) {
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

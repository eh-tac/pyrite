import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getChar, writeChar } from '@pyrite/core';
export abstract class RoleBase extends PyriteBase implements Byteable {
  public readonly ROLELENGTH: number = 4;
  public Team: string;
  public Designation: string;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Team = getChar(hex, 0x0, 1);
    this.Designation = getChar(hex, 0x1, 3);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Team: this.Team,
      Designation: this.Designation
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeChar(hex, this.Team, 0x0, 1);
    writeChar(hex, this.Designation, 0x1, 3);

    return hex;
  }

  public getLength(): number {
    return this.ROLELENGTH;
  }
}

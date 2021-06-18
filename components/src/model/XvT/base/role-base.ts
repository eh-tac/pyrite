import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getChar, writeChar } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class RoleBase extends PyriteBase implements Byteable {
  public readonly ROLELENGTH: number = 4;
  public Team: string;
  public Designation: string;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Team = getChar(hex, 0x0, 1);
    this.Designation = getChar(hex, 0x1, 3);
    
  }
  
  public toJSON(): object {
    return {
      Team: this.Team,
      Designation: this.DesignationLabel
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeChar(hex, this.Team, 0x0);
    writeChar(hex, this.Designation, 0x1);

    return hex;
  }
  
  public get DesignationLabel(): string {
    return Constants.DESIGNATION[this.Designation] || "Unknown";
  }
  
  public getLength(): number {
    return this.ROLELENGTH;
  }
}
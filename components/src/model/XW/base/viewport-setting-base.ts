import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getShort, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class ViewportSettingBase extends PyriteBase implements Byteable {
  public readonly VIEWPORTSETTINGLENGTH: number = 10;
  public Top: number;
  public Left: number;
  public Bottom: number;
  public Right: number;
  public Visible: number; //(boolean)
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Top = getShort(hex, 0x00);
    this.Left = getShort(hex, 0x02);
    this.Bottom = getShort(hex, 0x04);
    this.Right = getShort(hex, 0x06);
    this.Visible = getShort(hex, 0x08);
    
  }
  
  public toJSON(): object {
    return {
      Top: this.Top,
      Left: this.Left,
      Bottom: this.Bottom,
      Right: this.Right,
      Visible: this.Visible
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.Top, 0x00);
    writeShort(hex, this.Left, 0x02);
    writeShort(hex, this.Bottom, 0x04);
    writeShort(hex, this.Right, 0x06);
    writeShort(hex, this.Visible, 0x08);

    return hex;
  }
  
  
  public getLength(): number {
    return this.VIEWPORTSETTINGLENGTH;
  }
}
import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getShort, writeShort } from '@pyrite/core';
export abstract class ViewportSettingBase extends PyriteBase implements Byteable {
  public readonly VIEWPORTSETTINGLENGTH: number = 10;
  public Top: number;
  public Left: number;
  public Bottom: number;
  public Right: number;
  public Visible: number; //(boolean)

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Top = getShort(hex, 0x00);
    this.Left = getShort(hex, 0x02);
    this.Bottom = getShort(hex, 0x04);
    this.Right = getShort(hex, 0x06);
    this.Visible = getShort(hex, 0x08);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Top: this.Top,
      Left: this.Left,
      Bottom: this.Bottom,
      Right: this.Right,
      Visible: this.Visible
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

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

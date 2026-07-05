import { getString, writeByte, writeString } from "../../hex";
import { IMission } from "../pyrite-base";
import { XWAStringBase } from "./base/xwa-string-base";

export class XWAString extends XWAStringBase {
  public content: string;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    if (this.Magic === 0x00) {
      this.content = "";
      this.XWAStringLength = 1;
    } else {
      this.XWAStringLength = 64;
      this.content = getString(hex, 0x00, this.XWAStringLength);
    }
  }

  public toJSON(): string {
    return this.content;
  }

  public toHexBuffer(): ArrayBuffer {
    if (this.content) {
      this.XWAStringLength = 64;
      const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
      writeString(hex, this.content, 0x00, this.XWAStringLength);
      return hex;
    }
    const hex = new ArrayBuffer(1);
    writeByte(hex, this.Magic, 0x0);
    return hex;
  }

  public beforeConstruct(): void {}

  public toString(): string {
    return this.content;
  }
}

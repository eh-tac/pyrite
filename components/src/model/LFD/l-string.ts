import { LStringBase } from "./base/l-string-base";
import { getString } from "../../hex";

export class LString extends LStringBase {
  public beforeConstruct(): void {}

  public constructor(hex: ArrayBuffer, tie?: any) {
    super(hex, tie);
    let offset = 0x02;
    while (offset < this.Length) {
      const t = getString(hex, offset);
      this.Substrings.push(t);
      offset += t.length + 1;
    }
    // static prop Reserved
    offset += 1;
    this.LStringLength = offset;
  }

  public toString(): string {
    return "";
  }
}

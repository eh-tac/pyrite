import { TIEStringBase } from "./base/tie-string-base";
import { IMission } from "../../pyrite-base";

export class TIEString extends TIEStringBase {
  public toString() {
    return this.Text;
  }
  public constructor(hex: ArrayBuffer, tie: IMission) {
    super(hex, tie);
    this.TIEStringLength = this.Length + 2;
  }
}

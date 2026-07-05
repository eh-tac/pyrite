import { TagBase } from "./base/tag-base";
import { IMission } from "../../pyrite-base";

export class Tag extends TagBase {
  public toString() {
    return this.Text;
  }

  public constructor(hex: ArrayBuffer, tie: IMission) {
    super(hex, tie);
    this.TagLength = this.Length + 2;
  }
}

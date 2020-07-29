import { VoicBase } from "./base/voic-base";

export class Voic extends VoicBase {
  protected loadData() {
    throw new Error("Method not implemented.");
  }
  protected writeData() {
    throw new Error("Method not implemented.");
  }

  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }
}

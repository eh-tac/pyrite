import { CrosswordBase } from "./base/crossword-base";

export class Crossword extends CrosswordBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  protected GridSize(): number {
    return this.FileHeader.Height * this.FileHeader.Width;
  }
}

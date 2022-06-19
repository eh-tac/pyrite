import { FileHeaderBase } from "./base/file-header-base";

export class FileHeader extends FileHeaderBase {
  public get PrimaryCompleteMessage(): string {
    return this.EndOfMissionMessages.slice(0, 2)
      .join(" ")
      .trim();
  }

  public get SecondaryCompleteMessage(): string {
    return this.EndOfMissionMessages.slice(2, 4)
      .join(" ")
      .trim();
  }

  public get PrimaryFailMessage(): string {
    return this.EndOfMissionMessages.slice(4, 6)
      .join(" ")
      .trim();
  }
}

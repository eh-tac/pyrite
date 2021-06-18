import { RowBase } from "./base/row-base";

export class Row extends RowBase {
  protected ColorCount() {
    return 0;
  }
  protected OpCount() {
    return 0;
  }

  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }
}

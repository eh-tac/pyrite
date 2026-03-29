import { PLTCategoryTypeRecordBase } from "./base/plt-category-type-record-base";

export class PLTCategoryTypeRecord extends PLTCategoryTypeRecordBase {
  public Label: string = "";
  public beforeConstruct(): void {}

  public toString(): string {
    return this.Label;
  }
}

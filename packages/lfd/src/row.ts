import { RowBase } from './base/row-base';

export class Row extends RowBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected ColorCount(): number {
    return 0;
  }
  protected OpCount(): number {
    return 0;
  }
}

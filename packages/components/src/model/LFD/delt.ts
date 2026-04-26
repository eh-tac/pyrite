import { DeltBase } from "./base/delt-base";
    
export class Delt extends DeltBase {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected RowCount(): number {
    return 0;
  }
}

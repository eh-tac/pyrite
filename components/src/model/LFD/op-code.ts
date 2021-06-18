import { OpCodeBase } from "./base/op-code-base";
    
export class OpCode extends OpCodeBase {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected ColorCount(): number {
    return 0;
  }
}

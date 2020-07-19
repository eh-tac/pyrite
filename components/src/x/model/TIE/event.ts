import { EventBase } from "./base/event-base";
    
export class Event extends EventBase {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected VariableCount(): number {
    return 0;
  }
}

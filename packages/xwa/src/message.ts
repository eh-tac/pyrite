import { MessageBase } from './base/message-base';

export class Message extends MessageBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return `${this.MessageIndex}: ${this.Message}`;
  }

  public get isActive(): boolean {
    return !!this.Message;
  }
}

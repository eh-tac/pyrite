import type { IMission } from '../pyrite-base';
import { MessageBase } from './base/message-base';
import { Constants, MessageColor } from './constants';

export class Message extends MessageBase {
  public DisplayText: string;
  public MessageColour: MessageColor = MessageColor.red;

  public constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);

    this.DisplayText = this.Message;

    const num = Number(this.Message[0]);
    if (!Number.isNaN(num)) {
      this.MessageColour = num;
      this.DisplayText = this.Message.slice(1);
    }
  }

  public get MessageColourLabel(): string {
    return Constants.MESSAGECOLOR[this.MessageColour];
  }

  public toJSON(): Record<string, unknown> | string {
    const start = this.MessageColour === 0 ? 0 : 1;
    return {
      Message: this.Message.slice(start),
      MessageColour: this.MessageColourLabel,
      Triggers: this.Triggers,
      EditorNote: this.EditorNote,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2
    };
  }
}

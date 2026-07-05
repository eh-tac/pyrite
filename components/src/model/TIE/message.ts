import { MessageBase } from "./base/message-base";
import { Constants, MessageColor } from "./constants";
import { IMission } from "../pyrite-base";

export class Message extends MessageBase {
  public get MessageColourLabel(): string {
    return Constants.MESSAGECOLOR[this.MessageColour];
  }
  public DisplayText: string;
  public MessageColour: MessageColor = MessageColor.red;

  public constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);

    this.DisplayText = this.Message;

    const num = parseInt(this.Message[0], 10);
    if (!isNaN(num)) {
      this.MessageColour = num;
      this.DisplayText = this.Message.substr(1);
    }
  }

  public toJSON(): Record<string, unknown> | string {
    const start = this.MessageColour === 0 ? 0 : 1;
    return {
      Message: this.Message.substr(start),
      MessageColour: this.MessageColourLabel,
      Triggers: this.Triggers,
      EditorNote: this.EditorNote,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2,
    };
  }
}

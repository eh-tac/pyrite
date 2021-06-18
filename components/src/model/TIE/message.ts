import { MessageBase } from "./base/message-base";
import { Constants } from "./constants";
import { IMission } from "../pyrite-base";

export class Message extends MessageBase {
  public get MessageColourLabel(): string {
    return Constants.MESSAGECOLOR[this.MessageColour];
  }
  public DisplayText: string;
  public MessageColour = 0;

  public constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);

    this.DisplayText = this.Message;

    const num = parseInt(this.Message[0], 10);
    if (!isNaN(num)) {
      this.MessageColour = num;
      this.DisplayText = this.Message.substr(1);
    }
  }

  public toJSON(): object {
    const start = this.MessageColour === 0 ? 0 : 1;
    return {
      Message: this.Message.substr(start),
      MessageColour: this.MessageColourLabel,
      Triggers: this.Triggers,
      EditorNote: this.EditorNote,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2
    };
  }
}

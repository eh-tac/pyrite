import { ControllerBase } from "../../controller-base";
import { Message } from "../../model/XWA";

export class XWAMessageController extends ControllerBase {
  public readonly fields: object = {
    MessageIndex: { name: "MessageIndex", type: "SHORT" },
    Message: { name: "Message", type: "STR" },
    SentToTeam: { name: "SentToTeam", type: "BYTE" },
    Triggers: {
      name: "Triggers",
      type: "TriggerPair",
      componentTag: "pyrite-xwa-trigger-pair",
      componentProp: "triggerpair",
    },
    Voice: { name: "Voice", type: "STR" },
    OriginatingFG: { name: "OriginatingFG", type: "INT" },
    Type: { name: "Type", type: "INT" },
    Delay: { name: "Delay", type: "BYTE" },
    Triggers12OrTriggers34: { name: "Triggers12OrTriggers34", type: "BOOL" },
    Color: { name: "Color", type: "BYTE" },
    SpeakerHeader: { name: "SpeakerHeader", type: "BOOL" },
    Special: {
      name: "Special",
      type: "TriggerPair",
      componentTag: "pyrite-xwa-trigger-pair",
      componentProp: "triggerpair",
    },
    SpecialMeaning: { name: "SpecialMeaning", type: "BYTE" },
  };

  constructor(public model: Message) {
    super(model);
  }
}

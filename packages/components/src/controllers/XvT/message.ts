import { ControllerBase } from "../../controller-base";
import { Message } from "../../model/XvT";

export class XvTMessageController extends ControllerBase {
  public readonly fields: object = {"MessageIndex":{"name":"MessageIndex","type":"SHORT"},"Message":{"name":"Message","type":"CHAR"},"SentToTeams":{"name":"SentToTeams","type":"BYTE"},"TriggerA":{"name":"TriggerA","type":"Trigger","componentTag":"pyrite-xvt-trigger","componentProp":"trigger"},"Trigger1OrTrigger2":{"name":"Trigger1OrTrigger2","type":"BOOL"},"TriggerB":{"name":"TriggerB","type":"Trigger","componentTag":"pyrite-xvt-trigger","componentProp":"trigger"},"Trigger3OrTrigger4":{"name":"Trigger3OrTrigger4","type":"BOOL"},"EditorNote":{"name":"EditorNote","type":"STR"},"DelaySeconds":{"name":"DelaySeconds","type":"BYTE"},"Trigger12OrTrigger34":{"name":"Trigger12OrTrigger34","type":"BOOL"}};

  constructor(public model: Message){
    super(model);
  }
}
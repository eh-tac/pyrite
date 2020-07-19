import { ControllerBase } from "../../controller-base";
import { Message } from "../../model/TIE";

export class TIEMessageController extends ControllerBase {
  public readonly fields: object = {"Message":{"name":"Message","type":"STR"},"Triggers":{"name":"Triggers","type":"Trigger"},"EditorNote":{"name":"EditorNote","type":"STR"},"DelaySeconds":{"name":"DelaySeconds","type":"BYTE"},"Trigger1OrTrigger2":{"name":"Trigger1OrTrigger2","type":"BOOL"}};

  constructor(public model: Message){
    super(model);
  }
}
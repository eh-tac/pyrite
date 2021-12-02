import { ControllerBase } from "../../controller-base";
import { Message } from "../../model/XWA";

export class XWAMessageController extends ControllerBase {
  public readonly fields: object = {"MessageIndex":{"name":"MessageIndex","type":"SHORT"},"Message":{"name":"Message","type":"STR"},"SetToTeam":{"name":"SetToTeam","type":"BYTE"},"Trigger1":{"name":"Trigger1","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger2":{"name":"Trigger2","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Unknown1":{"name":"Unknown1","type":"BYTE"},"Trigger1OrTrigger2":{"name":"Trigger1OrTrigger2","type":"BOOL"},"Trigger3":{"name":"Trigger3","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger4":{"name":"Trigger4","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger3OrTrigger4":{"name":"Trigger3OrTrigger4","type":"BOOL"},"Voice":{"name":"Voice","type":"STR"},"OriginatingFG":{"name":"OriginatingFG","type":"BYTE"},"DelaySeconds":{"name":"DelaySeconds","type":"BYTE"},"Triggers12OrTriggers34":{"name":"Triggers12OrTriggers34","type":"BOOL"},"Color":{"name":"Color","type":"BYTE"},"Unknown2":{"name":"Unknown2","type":"BYTE"},"Cancel1":{"name":"Cancel1","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Cancel2":{"name":"Cancel2","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Cancel1OrCancel2":{"name":"Cancel1OrCancel2","type":"BOOL"},"Unknown3":{"name":"Unknown3","type":"BOOL"}};

  constructor(public model: Message){
    super(model);
  }
}
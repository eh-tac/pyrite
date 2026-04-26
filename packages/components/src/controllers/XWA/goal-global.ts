import { ControllerBase } from "../../controller-base";
import { GoalGlobal } from "../../model/XWA";

export class XWAGoalGlobalController extends ControllerBase {
  public readonly fields: object = {"Trigger1":{"name":"Trigger1","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger2":{"name":"Trigger2","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger1OrTrigger2":{"name":"Trigger1OrTrigger2","type":"BOOL"},"Unknown1":{"name":"Unknown1","type":"BOOL"},"Trigger3":{"name":"Trigger3","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger4":{"name":"Trigger4","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger3OrTrigger4":{"name":"Trigger3OrTrigger4","type":"BOOL"},"Unknown2":{"name":"Unknown2","type":"BOOL"},"Triggers12OrTriggers34":{"name":"Triggers12OrTriggers34","type":"BOOL"},"Unknown3":{"name":"Unknown3","type":"BYTE"},"Points":{"name":"Points","type":"SBYTE"},"Unknown4":{"name":"Unknown4","type":"BYTE"},"Unknown5":{"name":"Unknown5","type":"BYTE"},"Unknown6":{"name":"Unknown6","type":"BYTE"},"ActiveSquence":{"name":"ActiveSquence","type":"BYTE"}};

  constructor(public model: GoalGlobal){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { GoalGlobal } from "../../model/XvT";

export class XvTGoalGlobalController extends ControllerBase {
  public readonly fields: object = {"TriggerA":{"name":"TriggerA","type":"Trigger","componentTag":"pyrite-xvt-trigger","componentProp":"trigger"},"Trigger1OrTrigger2":{"name":"Trigger1OrTrigger2","type":"BOOL"},"TriggerB":{"name":"TriggerB","type":"Trigger","componentTag":"pyrite-xvt-trigger","componentProp":"trigger"},"Trigger2OrTrigger3":{"name":"Trigger2OrTrigger3","type":"BOOL"},"Trigger12OrTrigger34":{"name":"Trigger12OrTrigger34","type":"BOOL"},"Points":{"name":"Points","type":"SBYTE"}};

  constructor(public model: GoalGlobal){
    super(model);
  }
}
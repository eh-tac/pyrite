import { ControllerBase } from "../../controller-base";
import { GlobalGoal } from "../../model/TIE";

export class TIEGlobalGoalController extends ControllerBase {
  public readonly fields: object = {"Triggers":{"name":"Triggers","type":"Trigger"},"Trigger1OrTrigger2":{"name":"Trigger1OrTrigger2","type":"BOOL"}};

  constructor(public model: GlobalGoal){
    super(model);
  }
}
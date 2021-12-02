import { ControllerBase } from "../../controller-base";
import { GlobalGoal } from "../../model/XWA";

export class XWAGlobalGoalController extends ControllerBase {
  public readonly fields: object = {"Reserved":{"name":"Reserved","type":"SHORT"},"Unnamed":{"name":"Unnamed","type":"GoalGlobal","componentTag":"pyrite-xwa-goal-global","componentProp":"goalglobal"}};

  constructor(public model: GlobalGoal){
    super(model);
  }
}
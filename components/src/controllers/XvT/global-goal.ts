import { ControllerBase } from "../../controller-base";
import { GlobalGoal } from "../../model/XvT";

export class XvTGlobalGoalController extends ControllerBase {
  public readonly fields: object = {"Reserved":{"name":"Reserved","type":"SHORT"},"Goal":{"name":"Goal","type":"GoalGlobal","componentTag":"pyrite-xvt-goal-global","componentProp":"goalglobal"}};

  constructor(public model: GlobalGoal){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { GlobalGoal } from "../../../old-assets/model/XWA";

export class XWAGlobalGoalController extends ControllerBase {
  public readonly fields: object = {
    Reserved: { name: "Reserved", type: "SHORT" },
    Goal: { name: "Goal", type: "GoalGlobal", componentTag: "pyrite-xwa-goal-global", componentProp: "goalglobal" },
  };

  constructor(public model: GlobalGoal) {
    super(model);
  }
}

import { ControllerBase } from "../../controller-base";
import { GoalGlobal } from "../../../old-assets/model/XWA";

export class XWAGoalGlobalController extends ControllerBase {
  public readonly fields: object = {
    Triggers: {
      name: "Triggers",
      type: "TriggerPair",
      componentTag: "pyrite-xwa-trigger-pair",
      componentProp: "triggerpair",
    },
    Name: { name: "Name", type: "STR" },
    Version: { name: "Version", type: "BYTE" },
    Triggers12OrTriggers34: { name: "Triggers12OrTriggers34", type: "BOOL" },
    Delay: { name: "Delay", type: "BYTE" },
    Points: { name: "Points", type: "SBYTE" },
    PointsPerTrigger: { name: "PointsPerTrigger", type: "BYTE" },
    ActiveSquence: { name: "ActiveSquence", type: "BYTE" },
  };

  constructor(public model: GoalGlobal) {
    super(model);
  }
}

import { ControllerBase } from "../../controller-base";
import { GoalFG } from "../../../old-assets/model/XWA";

export class XWAGoalFGController extends ControllerBase {
  public readonly fields: object = {
    Argument: { name: "Argument", type: "BYTE" },
    Condition: { name: "Condition", type: "BYTE" },
    Amount: { name: "Amount", type: "BYTE" },
    Points: { name: "Points", type: "SBYTE" },
    EnabledForTeam: { name: "EnabledForTeam", type: "BOOL" },
    Parameter: { name: "Parameter", type: "BYTE" },
    ActiveSequence: { name: "ActiveSequence", type: "BYTE" },
  };

  constructor(public model: GoalFG) {
    super(model);
  }
}

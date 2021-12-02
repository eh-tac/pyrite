import { ControllerBase } from "../../controller-base";
import { GoalFG } from "../../model/XWA";

export class XWAGoalFGController extends ControllerBase {
  public readonly fields: object = {"Argument":{"name":"Argument","type":"BYTE"},"Condition":{"name":"Condition","type":"BYTE"},"Amount":{"name":"Amount","type":"BYTE"},"Points":{"name":"Points","type":"SBYTE"},"Enabled":{"name":"Enabled","type":"BOOL"},"Team":{"name":"Team","type":"BYTE"},"Unknown42":{"name":"Unknown42","type":"BYTE"},"Parameter":{"name":"Parameter","type":"BYTE"},"ActiveSequence":{"name":"ActiveSequence","type":"BYTE"},"Unknown15":{"name":"Unknown15","type":"BOOL"}};

  constructor(public model: GoalFG){
    super(model);
  }
}
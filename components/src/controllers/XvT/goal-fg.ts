import { ControllerBase } from "../../controller-base";
import { GoalFG } from "../../model/XvT";

export class XvTGoalFGController extends ControllerBase {
  public readonly fields: object = {"Argument":{"name":"Argument","type":"BYTE"},"Condition":{"name":"Condition","type":"BYTE","options":"Constants.CONDITION"},"Amount":{"name":"Amount","type":"BYTE","options":"Constants.AMOUNT"},"Points":{"name":"Points","type":"SBYTE"},"Enabled":{"name":"Enabled","type":"BOOL"},"Team":{"name":"Team","type":"BYTE"},"Unknown10":{"name":"Unknown10","type":"BOOL"},"Unknown11":{"name":"Unknown11","type":"BOOL"},"Unknown12":{"name":"Unknown12","type":"BOOL"},"Unknown13":{"name":"Unknown13","type":"BYTE"},"Unknown14":{"name":"Unknown14","type":"BOOL"},"Reserved":{"name":"Reserved","type":"BYTE"},"Unknown16":{"name":"Unknown16","type":"BYTE"}};

  constructor(public model: GoalFG){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { GoalFG } from "../../model/TIE";

export class TIEGoalFGController extends ControllerBase {
  public readonly fields: object = {"Condition":{"name":"Condition","type":"BYTE","options":"Constants.CONDITION"},"GoalAmount":{"name":"GoalAmount","type":"BYTE","options":"Constants.GOALAMOUNT"}};

  constructor(public model: GoalFG){
    super(model);
  }
}
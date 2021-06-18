import { ControllerBase } from "../../controller-base";
import { Trigger } from "../../model/XvT";

export class XvTTriggerController extends ControllerBase {
  public readonly fields: object = {"Condition":{"name":"Condition","type":"BYTE","options":"Constants.CONDITION"},"VariableType":{"name":"VariableType","type":"BYTE","options":"Constants.VARIABLETYPE"},"Variable":{"name":"Variable","type":"BYTE"},"Amount":{"name":"Amount","type":"BYTE","options":"Constants.AMOUNT"}};

  constructor(public model: Trigger){
    super(model);
  }
}
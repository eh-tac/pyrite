import { ControllerBase } from "../../controller-base";
import { Trigger } from "../../model/XWA";

export class XWATriggerController extends ControllerBase {
  public readonly fields: object = {"Condition":{"name":"Condition","type":"BYTE","options":"Constants.CONDITION"},"VariableType":{"name":"VariableType","type":"BYTE","options":"Constants.VARIABLETYPE"},"Variable":{"name":"Variable","type":"BYTE"},"Amount":{"name":"Amount","type":"BYTE","options":"Constants.AMOUNT"},"Parameter":{"name":"Parameter","type":"BYTE"},"Parameter2":{"name":"Parameter2","type":"BYTE"}};

  constructor(public model: Trigger){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Trigger } from "../../model/TIE";

export class TIETriggerController extends ControllerBase {
  public readonly fields: object = {"Condition":{"name":"Condition","type":"BYTE","options":"Constants.CONDITION"},"VariableType":{"name":"VariableType","type":"BYTE","options":"Constants.VARIABLETYPE"},"Variable":{"name":"Variable","type":"BYTE"},"TriggerAmount":{"name":"TriggerAmount","type":"BYTE","options":"Constants.TRIGGERAMOUNT"}};

  constructor(public model: Trigger){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Order } from "../../model/XvT";

export class XvTOrderController extends ControllerBase {
  public readonly fields: object = {"Order":{"name":"Order","type":"BYTE","options":"Constants.ORDER"},"Throttle":{"name":"Throttle","type":"BYTE"},"Variable1":{"name":"Variable1","type":"BYTE"},"Variable2":{"name":"Variable2","type":"BYTE"},"Unknown6":{"name":"Unknown6","type":"BYTE"},"Unknown7":{"name":"Unknown7","type":"BYTE"},"Target3Type":{"name":"Target3Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target4Type":{"name":"Target4Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target3":{"name":"Target3","type":"BYTE"},"Target4":{"name":"Target4","type":"BYTE"},"Target3OrTarget4":{"name":"Target3OrTarget4","type":"BOOL"},"Unknown8":{"name":"Unknown8","type":"BYTE"},"Target1Type":{"name":"Target1Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target1":{"name":"Target1","type":"BYTE"},"Target2Type":{"name":"Target2Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target2":{"name":"Target2","type":"BYTE"},"Target1OrTarget2":{"name":"Target1OrTarget2","type":"BOOL"},"Unknown9":{"name":"Unknown9","type":"BYTE"},"Speed":{"name":"Speed","type":"BYTE"},"Designation":{"name":"Designation","type":"STR"}};

  constructor(public model: Order){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Order } from "../../model/XWA";

export class XWAOrderController extends ControllerBase {
  public readonly fields: object = {"Order":{"name":"Order","type":"BYTE","options":"Constants.ORDER"},"Throttle":{"name":"Throttle","type":"BYTE"},"Variable1":{"name":"Variable1","type":"BYTE"},"Variable2":{"name":"Variable2","type":"BYTE"},"Variable3":{"name":"Variable3","type":"BYTE"},"Unknown9":{"name":"Unknown9","type":"BYTE"},"Target3Type":{"name":"Target3Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target4Type":{"name":"Target4Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target3":{"name":"Target3","type":"BYTE"},"Target4":{"name":"Target4","type":"BYTE"},"Target3OrTarget4":{"name":"Target3OrTarget4","type":"BOOL"},"Target1Type":{"name":"Target1Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target1":{"name":"Target1","type":"BYTE"},"Target2Type":{"name":"Target2Type","type":"BYTE","options":"Constants.VARIABLETYPE"},"Target2":{"name":"Target2","type":"BYTE"},"Target1OrTarget2":{"name":"Target1OrTarget2","type":"BOOL"},"Speed":{"name":"Speed","type":"BYTE"},"Unnamed":{"name":"Unnamed","type":"Waypt","componentTag":"pyrite-xwa-waypt","componentProp":"waypt"},"Unknown10":{"name":"Unknown10","type":"BYTE"},"Unknown11":{"name":"Unknown11","type":"BOOL"},"Unknown12":{"name":"Unknown12","type":"BOOL"},"Unknown13":{"name":"Unknown13","type":"BOOL"},"Unknown14":{"name":"Unknown14","type":"BOOL"}};

  constructor(public model: Order){
    super(model);
  }
}
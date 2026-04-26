import { ControllerBase } from "../../controller-base";
import { Skip } from "../../model/XWA";

export class XWASkipController extends ControllerBase {
  public readonly fields: object = {"Trigger1":{"name":"Trigger1","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger2":{"name":"Trigger2","type":"Trigger","componentTag":"pyrite-xwa-trigger","componentProp":"trigger"},"Trigger1OrTrigger2":{"name":"Trigger1OrTrigger2","type":"BOOL"}};

  constructor(public model: Skip){
    super(model);
  }
}
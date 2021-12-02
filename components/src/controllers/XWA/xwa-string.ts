import { ControllerBase } from "../../controller-base";
import { XWAString } from "../../model/XWA";

export class XWAStringController extends ControllerBase {
  public readonly fields: object = {"Magic":{"name":"Magic","type":"BYTE"}};

  constructor(public model: XWAString){
    super(model);
  }
}
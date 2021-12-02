import { ControllerBase } from "../../controller-base";
import { Waypt } from "../../model/XWA";

export class XWAWayptController extends ControllerBase {
  public readonly fields: object = {"X":{"name":"X","type":"SHORT"},"Y":{"name":"Y","type":"SHORT"},"Z":{"name":"Z","type":"SHORT"},"Enabled":{"name":"Enabled","type":"BOOL"}};

  constructor(public model: Waypt){
    super(model);
  }
}
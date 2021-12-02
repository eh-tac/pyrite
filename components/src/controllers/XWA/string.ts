import { ControllerBase } from "../../controller-base";
import { String } from "../../model/XWA";

export class XWAStringController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Unnamed":{"name":"Unnamed","type":"CHAR"}};

  constructor(public model: String){
    super(model);
  }
}
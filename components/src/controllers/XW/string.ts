import { ControllerBase } from "../../controller-base";
import { String } from "../../model/XW";

export class XWStringController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"String":{"name":"String","type":"CHAR"},"Highlight":{"name":"Highlight","type":"BYTE"}};

  constructor(public model: String){
    super(model);
  }
}
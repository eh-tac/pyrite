import { ControllerBase } from "../../controller-base";
import { XvTString } from "../../model/XvT";

export class XvTStringController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Text":{"name":"Text","type":"CHAR"}};

  constructor(public model: XvTString){
    super(model);
  }
}
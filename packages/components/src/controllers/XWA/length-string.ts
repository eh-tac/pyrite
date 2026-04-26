import { ControllerBase } from "../../controller-base";
import { LengthString } from "../../model/XWA";

export class XWALengthStringController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Text":{"name":"Text","type":"CHAR"}};

  constructor(public model: LengthString){
    super(model);
  }
}
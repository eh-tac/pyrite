import { ControllerBase } from "../../controller-base";
import { Tag } from "../../model/XvT";

export class XvTTagController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Text":{"name":"Text","type":"CHAR"}};

  constructor(public model: Tag){
    super(model);
  }
}
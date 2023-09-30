import { ControllerBase } from "../../controller-base";
import { Tag } from "../../model/XW";

export class XWTagController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Unnamed":{"name":"Unnamed","type":"CHAR"}};

  constructor(public model: Tag){
    super(model);
  }
}
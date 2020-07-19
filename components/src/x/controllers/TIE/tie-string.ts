import { ControllerBase } from "../../controller-base";
import { TIEString } from "../../model/TIE";

export class TIETIEStringController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Text":{"name":"Text","type":"CHAR"}};

  constructor(public model: TIEString){
    super(model);
  }
}
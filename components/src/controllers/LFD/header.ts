import { ControllerBase } from "../../controller-base";
import { Header } from "../../model/LFD";

export class LFDHeaderController extends ControllerBase {
  public readonly fields: object = {"Type":{"name":"Type","type":"CHAR"},"Name":{"name":"Name","type":"CHAR"},"Length":{"name":"Length","type":"INT"}};

  constructor(public model: Header){
    super(model);
  }
}
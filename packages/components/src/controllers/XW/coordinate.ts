import { ControllerBase } from "../../controller-base";
import { Coordinate } from "../../model/XW";

export class XWCoordinateController extends ControllerBase {
  public readonly fields: object = {"X":{"name":"X","type":"SHORT"},"Y":{"name":"Y","type":"SHORT"},"Z":{"name":"Z","type":"SHORT"}};

  constructor(public model: Coordinate){
    super(model);
  }
}
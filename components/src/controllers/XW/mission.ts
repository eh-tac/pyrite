import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/XW";

export class XWMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader"},"Unnamed":{"name":"Unnamed","type":"ObjectGroup"}};

  constructor(public model: Mission){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Role } from "../../model/XvT";

export class XvTRoleController extends ControllerBase {
  public readonly fields: object = {"Team":{"name":"Team","type":"CHAR"},"Designation":{"name":"Designation","type":"CHAR","options":"Constants.DESIGNATION"}};

  constructor(public model: Role){
    super(model);
  }
}
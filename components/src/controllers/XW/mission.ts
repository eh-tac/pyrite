import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/XW";

export class XWMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader","componentTag":"pyrite-xw-file-header","componentProp":"file-header"},"Unnamed":{"name":"Unnamed","type":"ObjectGroup","componentTag":"pyrite-xw-object-group","componentProp":"object-group"}};

  constructor(public model: Mission){
    super(model);
  }
}
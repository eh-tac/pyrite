import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/XW";

export class XWMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader","componentTag":"pyrite-xw-file-header","componentProp":"fileheader"},"FlightGroups":{"name":"FlightGroups","type":"FlightGroup","componentTag":"pyrite-xw-flight-group","componentProp":"flightgroup"},"ObjectGroups":{"name":"ObjectGroups","type":"ObjectGroup","componentTag":"pyrite-xw-object-group","componentProp":"objectgroup"}};

  constructor(public model: Mission){
    super(model);
  }
}
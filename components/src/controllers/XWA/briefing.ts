import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../model/XWA";

export class XWABriefingController extends ControllerBase {
  public readonly fields: object = {"RunningTime":{"name":"RunningTime","type":"SHORT"},"Unknown1":{"name":"Unknown1","type":"SHORT"},"StartLength":{"name":"StartLength","type":"SHORT"},"EventsLength":{"name":"EventsLength","type":"INT"},"Unnamed":{"name":"Unnamed","type":"LengthString","componentTag":"pyrite-xwa-length-string","componentProp":"lengthstring"},"ShowToTeams":{"name":"ShowToTeams","type":"BOOL"}};

  constructor(public model: Briefing){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../model/XWA";

export class XWABriefingController extends ControllerBase {
  public readonly fields: object = {"RunningTime":{"name":"RunningTime","type":"SHORT"},"Unknown1":{"name":"Unknown1","type":"SHORT"},"StartLength":{"name":"StartLength","type":"SHORT"},"EventsLength":{"name":"EventsLength","type":"INT"},"Events":{"name":"Events","type":"Event","componentTag":"pyrite-xwa-event","componentProp":"event"},"ShowToTeams":{"name":"ShowToTeams","type":"BOOL"},"Tags":{"name":"Tags","type":"Tag","componentTag":"pyrite-xwa-tag","componentProp":"tag"},"Strings":{"name":"Strings","type":"LengthString","componentTag":"pyrite-xwa-length-string","componentProp":"lengthstring"}};

  constructor(public model: Briefing){
    super(model);
  }
}
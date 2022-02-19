import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../model/TIE";

export class TIEBriefingController extends ControllerBase {
  public readonly fields: object = {"RunningTime":{"name":"RunningTime","type":"SHORT"},"Unknown":{"name":"Unknown","type":"SHORT"},"StartLength":{"name":"StartLength","type":"SHORT"},"EventsLength":{"name":"EventsLength","type":"INT"},"Events":{"name":"Events","type":"Event","componentTag":"pyrite-tie-event","componentProp":"event"},"Tags":{"name":"Tags","type":"Tag","componentTag":"pyrite-tie-tag","componentProp":"tag"},"Strings":{"name":"Strings","type":"TIEString","componentTag":"pyrite-tie-tie-string","componentProp":"tiestring"}};

  constructor(public model: Briefing){
    super(model);
  }
}
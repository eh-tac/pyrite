import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../model/XvT";

export class XvTBriefingController extends ControllerBase {
  public readonly fields: object = {"RunningTime":{"name":"RunningTime","type":"SHORT"},"Unknown1":{"name":"Unknown1","type":"SHORT"},"StartEvents":{"name":"StartEvents","type":"SHORT"},"EventsLength":{"name":"EventsLength","type":"INT"},"Events":{"name":"Events","type":"Event","componentTag":"pyrite-xvt-event","componentProp":"event"},"Tags":{"name":"Tags","type":"Tag","componentTag":"pyrite-xvt-tag","componentProp":"tag"},"Strings":{"name":"Strings","type":"XvTString","componentTag":"pyrite-xvt-xv-t-string","componentProp":"xvtstring"}};

  constructor(public model: Briefing){
    super(model);
  }
}
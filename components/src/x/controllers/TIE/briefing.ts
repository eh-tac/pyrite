import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../model/TIE";

export class TIEBriefingController extends ControllerBase {
  public readonly fields: object = {"RunningTime":{"name":"RunningTime","type":"SHORT"},"Unknown":{"name":"Unknown","type":"SHORT"},"StartLength":{"name":"StartLength","type":"SHORT"},"EventsLength":{"name":"EventsLength","type":"INT"},"Events":{"name":"Events","type":"Event"},"Tags":{"name":"Tags","type":"Tag"},"Strings":{"name":"Strings","type":"TIEString"}};

  constructor(public model: Briefing){
    super(model);
  }
}
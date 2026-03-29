import { ControllerBase } from "../../controller-base";
import { PLTEarnedMedalRecord } from "../../model/XvT";

export class XvTPLTEarnedMedalRecordController extends ControllerBase {
  public readonly fields: object = {"meleePlaqueCount":{"name":"meleePlaqueCount","type":"INT"},"tournamentPlaqueCount":{"name":"tournamentPlaqueCount","type":"INT"},"exerciseBadgeCount":{"name":"exerciseBadgeCount","type":"INT"},"battleMedalCount":{"name":"battleMedalCount","type":"INT"}};

  constructor(public model: PLTEarnedMedalRecord){
    super(model);
  }
}
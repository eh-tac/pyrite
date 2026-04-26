import { ControllerBase } from "../../controller-base";
import { MissionData } from "../../model/XvT";

export class XvTMissionDataController extends ControllerBase {
  public readonly fields: object = {"AttemptCount":{"name":"AttemptCount","type":"INT"},"WinCount":{"name":"WinCount","type":"INT"},"LossCount":{"name":"LossCount","type":"INT"},"BestScore":{"name":"BestScore","type":"INT"},"BestTime":{"name":"BestTime","type":"INT"},"BestTimeSecond":{"name":"BestTimeSecond","type":"INT"},"BestRating":{"name":"BestRating","type":"INT","options":"Constants.BESTRATING"},"Something":{"name":"Something","type":"INT"},"Other":{"name":"Other","type":"INT"}};

  constructor(public model: MissionData){
    super(model);
  }
}
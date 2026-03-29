import { ControllerBase } from "../../controller-base";
import { PL2CampaignRecord } from "../../model/XvT";

export class XvTPL2CampaignRecordController extends ControllerBase {
  public readonly fields: object = {"IDNumber":{"name":"IDNumber","type":"INT"},"totalCountFlown":{"name":"totalCountFlown","type":"INT"},"isMissionCompleteWithoutCheat":{"name":"isMissionCompleteWithoutCheat","type":"INT"},"bestScore":{"name":"bestScore","type":"INT"},"bestEvaluationBadge":{"name":"bestEvaluationBadge","type":"INT"},"bestTimeAsSeconds":{"name":"bestTimeAsSeconds","type":"INT"},"isMissionComplete":{"name":"isMissionComplete","type":"INT"},"UIFrameTimerHelper":{"name":"UIFrameTimerHelper","type":"INT"}};

  constructor(public model: PL2CampaignRecord){
    super(model);
  }
}
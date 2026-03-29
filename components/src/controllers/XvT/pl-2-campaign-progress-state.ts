import { ControllerBase } from "../../controller-base";
import { PL2CampaignProgressState } from "../../model/XvT";

export class XvTPL2CampaignProgressStateController extends ControllerBase {
  public readonly fields: object = {"unknown1":{"name":"unknown1","type":"INT"},"CurrentMissionNumber":{"name":"CurrentMissionNumber","type":"INT"},"totalMissionCount":{"name":"totalMissionCount","type":"INT"},"CurrentMissionComplete":{"name":"CurrentMissionComplete","type":"INT"},"PlayerCount":{"name":"PlayerCount","type":"INT"},"totalScore":{"name":"totalScore","type":"INT"}};

  constructor(public model: PL2CampaignProgressState){
    super(model);
  }
}
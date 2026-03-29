import { ControllerBase } from "../../controller-base";
import { PL2CampaignState } from "../../model/XvT";

export class XvTPL2CampaignStateController extends ControllerBase {
  public readonly fields: object = {"ConfigRandomSeed":{"name":"ConfigRandomSeed","type":"INT"},"IsInProgressUNK":{"name":"IsInProgressUNK","type":"INT"},"ConfigGameRandomizeLevel":{"name":"ConfigGameRandomizeLevel","type":"INT"},"saveState":{"name":"saveState","type":"PL2CampaignProgressState","componentTag":"pyrite-xvt-pl-2-campaign-progress-state","componentProp":"pl2campaignprogressstate"},"unknown2":{"name":"unknown2","type":"INT"}};

  constructor(public model: PL2CampaignState){
    super(model);
  }
}
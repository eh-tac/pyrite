import { ControllerBase } from "../../controller-base";
import { PL2CampaignStatusSPRecord } from "../../model/XvT";

export class XvTPL2CampaignStatusSPRecordController extends ControllerBase {
  public readonly fields: object = {"unknown0x0":{"name":"unknown0x0","type":"INT"},"isStartedUNK":{"name":"isStartedUNK","type":"INT"},"missionNumber":{"name":"missionNumber","type":"INT"},"isFinished":{"name":"isFinished","type":"INT"},"bestScore":{"name":"bestScore","type":"INT"},"unknown0x14":{"name":"unknown0x14","type":"INT"},"unknown0x18":{"name":"unknown0x18","type":"INT"},"unknown0x1C":{"name":"unknown0x1C","type":"INT"},"unknown0x20":{"name":"unknown0x20","type":"INT"}};

  constructor(public model: PL2CampaignStatusSPRecord){
    super(model);
  }
}
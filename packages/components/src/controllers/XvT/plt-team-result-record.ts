import { ControllerBase } from "../../controller-base";
import { PLTTeamResultRecord } from "../../model/XvT";

export class XvTPLTTeamResultRecordController extends ControllerBase {
  public readonly fields: object = {"totalMissionScore":{"name":"totalMissionScore","type":"INT"},"isMissionComplete":{"name":"isMissionComplete","type":"INT"},"unknown0x8":{"name":"unknown0x8","type":"INT"},"timeMissionComplete":{"name":"timeMissionComplete","type":"INT"},"fullKills":{"name":"fullKills","type":"INT"},"sharedKills":{"name":"sharedKills","type":"INT"},"losses":{"name":"losses","type":"INT"}};

  constructor(public model: PLTTeamResultRecord){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { PLTTournTeamRecord } from "../../model/XvT";

export class XvTPLTTournTeamRecordController extends ControllerBase {
  public readonly fields: object = {"teamParticipationState":{"name":"teamParticipationState","type":"INT"},"totalTeamScore":{"name":"totalTeamScore","type":"INT"},"numberOfMeleeRankingsFirst":{"name":"numberOfMeleeRankingsFirst","type":"INT"},"numberOfMeleeRankingsSecond":{"name":"numberOfMeleeRankingsSecond","type":"INT"},"numberOfMeleeRankingsThird":{"name":"numberOfMeleeRankingsThird","type":"INT"}};

  constructor(public model: PLTTournTeamRecord){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { PLTMissionMPRecord } from "../../model/XvT";

export class XvTPLTMissionMPRecordController extends ControllerBase {
  public readonly fields: object = {"unknown0x0":{"name":"unknown0x0","type":"INT"},"totalCountFlown":{"name":"totalCountFlown","type":"INT"},"totalCountFinishedFirst":{"name":"totalCountFinishedFirst","type":"INT"},"totalCountFinishedSecond":{"name":"totalCountFinishedSecond","type":"INT"},"totalCountFinishedThird":{"name":"totalCountFinishedThird","type":"INT"},"totalCountVictory":{"name":"totalCountVictory","type":"INT"},"totalCountFailure":{"name":"totalCountFailure","type":"INT"},"bestScore":{"name":"bestScore","type":"INT"},"bestTimeAsSeconds":{"name":"bestTimeAsSeconds","type":"INT"},"bestFinishPlace":{"name":"bestFinishPlace","type":"INT"},"bestEvaluationBadge":{"name":"bestEvaluationBadge","type":"INT"},"bestWinningMargin":{"name":"bestWinningMargin","type":"INT"}};

  constructor(public model: PLTMissionMPRecord){
    super(model);
  }
}
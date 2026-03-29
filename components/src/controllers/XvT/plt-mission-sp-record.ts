import { ControllerBase } from "../../controller-base";
import { PLTMissionSPRecord } from "../../model/XvT";

export class XvTPLTMissionSPRecordController extends ControllerBase {
  public readonly fields: object = {"unknown0x0":{"name":"unknown0x0","type":"INT"},"totalCountFlown":{"name":"totalCountFlown","type":"INT"},"totalCountVictory":{"name":"totalCountVictory","type":"INT"},"totalCountFailure":{"name":"totalCountFailure","type":"INT"},"bestScore":{"name":"bestScore","type":"INT"},"bestTimeAsSeconds":{"name":"bestTimeAsSeconds","type":"INT"},"bestFinishRank":{"name":"bestFinishRank","type":"INT"},"bestEvaluationBadge":{"name":"bestEvaluationBadge","type":"INT"},"bestWinningMargin":{"name":"bestWinningMargin","type":"INT"}};

  constructor(public model: PLTMissionSPRecord){
    super(model);
  }
}
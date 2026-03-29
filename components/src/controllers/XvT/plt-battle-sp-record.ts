import { ControllerBase } from "../../controller-base";
import { PLTBattleSPRecord } from "../../model/XvT";

export class XvTPLTBattleSPRecordController extends ControllerBase {
  public readonly fields: object = {"unknown0x0":{"name":"unknown0x0","type":"INT"},"totalCountFlown":{"name":"totalCountFlown","type":"INT"},"totalCountVictory":{"name":"totalCountVictory","type":"INT"},"totalCountFailure":{"name":"totalCountFailure","type":"INT"},"totalCount10MissionMarathonUNK":{"name":"totalCount10MissionMarathonUNK","type":"INT"},"bestScore":{"name":"bestScore","type":"INT"},"unknown0x18":{"name":"unknown0x18","type":"INT"},"bestEvaluationMedal":{"name":"bestEvaluationMedal","type":"INT"},"bestVictoryMargin":{"name":"bestVictoryMargin","type":"INT"}};

  constructor(public model: PLTBattleSPRecord){
    super(model);
  }
}
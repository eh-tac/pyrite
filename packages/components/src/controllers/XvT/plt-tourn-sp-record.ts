import { ControllerBase } from "../../controller-base";
import { PLTTournSPRecord } from "../../model/XvT";

export class XvTPLTTournSPRecordController extends ControllerBase {
  public readonly fields: object = {"unknown0x0":{"name":"unknown0x0","type":"INT"},"totalCountFlown":{"name":"totalCountFlown","type":"INT"},"numberOfFinishesAnyUNK":{"name":"numberOfFinishesAnyUNK","type":"INT"},"numberOfFinishesFirst":{"name":"numberOfFinishesFirst","type":"INT"},"numberOfFinishesSecond":{"name":"numberOfFinishesSecond","type":"INT"},"numberOfFinishesThird":{"name":"numberOfFinishesThird","type":"INT"},"bestScore":{"name":"bestScore","type":"INT"},"bestFinish":{"name":"bestFinish","type":"INT"},"bestEvaluationMedal":{"name":"bestEvaluationMedal","type":"INT"},"bestFinishPointMargin":{"name":"bestFinishPointMargin","type":"INT"}};

  constructor(public model: PLTTournSPRecord){
    super(model);
  }
}
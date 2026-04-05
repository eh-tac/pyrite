import { ControllerBase } from "../../controller-base";
import { PLTAIRankCountRecord } from "../../model/XvT";

export class XvTPLTAIRankCountRecordController extends ControllerBase {
  public readonly fields: object = {"exercise":{"name":"exercise","type":"INT"},"melee":{"name":"melee","type":"INT"},"combat":{"name":"combat","type":"INT"}};

  constructor(public model: PLTAIRankCountRecord){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { PLTPlayerRankCountRecord } from "../../model/XvT";

export class XvTPLTPlayerRankCountRecordController extends ControllerBase {
  public readonly fields: object = {"exercise":{"name":"exercise","type":"INT"},"melee":{"name":"melee","type":"INT"},"combat":{"name":"combat","type":"INT"}};

  constructor(public model: PLTPlayerRankCountRecord){
    super(model);
  }
}
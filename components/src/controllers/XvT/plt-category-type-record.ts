import { ControllerBase } from "../../controller-base";
import { PLTCategoryTypeRecord } from "../../model/XvT";

export class XvTPLTCategoryTypeRecordController extends ControllerBase {
  public readonly fields: object = {"exercise":{"name":"exercise","type":"INT"},"melee":{"name":"melee","type":"INT"},"combat":{"name":"combat","type":"INT"}};

  constructor(public model: PLTCategoryTypeRecord){
    super(model);
  }
}
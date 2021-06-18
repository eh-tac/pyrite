import { ControllerBase } from "../../controller-base";
import { OpCode } from "../../model/LFD";

export class LFDOpCodeController extends ControllerBase {
  public readonly fields: object = {"Value":{"name":"Value","type":"BYTE"},"ColorIndex":{"name":"ColorIndex","type":"BYTE"}};

  constructor(public model: OpCode){
    super(model);
  }
}
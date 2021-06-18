import { ControllerBase } from "../../controller-base";
import { Row } from "../../model/LFD";

export class LFDRowController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Left":{"name":"Left","type":"SHORT"},"Top":{"name":"Top","type":"SHORT"},"ColorIndexes":{"name":"ColorIndexes","type":"BYTE"},"Operations":{"name":"Operations","type":"OpCode","componentTag":"pyrite-lfd-op-code","componentProp":"op-code"}};

  constructor(public model: Row){
    super(model);
  }
}
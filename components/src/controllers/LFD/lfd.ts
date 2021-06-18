import { ControllerBase } from "../../controller-base";
import { LFD } from "../../model/LFD";

export class LFDController extends ControllerBase {
  public readonly fields: object = {"Header":{"name":"Header","type":"Header","componentTag":"pyrite-lfd-header","componentProp":"header"}};

  constructor(public model: LFD){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Rmap } from "../../model/LFD";

export class LFDRmapController extends ControllerBase {
  public readonly fields: object = {"Header":{"name":"Header","type":"Header","componentTag":"pyrite-lfd-header","componentProp":"header"},"Subheaders":{"name":"Subheaders","type":"Header","componentTag":"pyrite-lfd-header","componentProp":"header"}};

  constructor(public model: Rmap){
    super(model);
  }
}
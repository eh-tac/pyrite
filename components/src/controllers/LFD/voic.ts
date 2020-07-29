import { ControllerBase } from "../../controller-base";
import { Voic } from "../../model/LFD";

export class LFDVoicController extends ControllerBase {
  public readonly fields: object = {"Header":{"name":"Header","type":"Header","componentTag":"pyrite-lfd-header","componentProp":"header"},"Data":{"name":"Data","type":"any"}};

  constructor(public model: Voic){
    super(model);
  }
}
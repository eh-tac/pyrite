import { ControllerBase } from "../../controller-base";
import { VoicData } from "../../model/LFD";

export class LFDVoicDataController extends ControllerBase {
  public readonly fields: object = {"Type":{"name":"Type","type":"BYTE"},"Size":{"name":"Size","type":"BYTE"},"Data":{"name":"Data","type":"any"}};

  constructor(public model: VoicData){
    super(model);
  }
}
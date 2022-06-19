import { ControllerBase } from "../../controller-base";
import { Voic } from "../../model/LFD";

export class LFDVoicController extends ControllerBase {
  public readonly fields: object = {"Header":{"name":"Header","type":"Header","componentTag":"pyrite-lfd-header","componentProp":"header"},"Creative":{"name":"Creative","type":"CHAR"},"Abort":{"name":"Abort","type":"BYTE"},"Version":{"name":"Version","type":"BYTE"},"VersionHash":{"name":"VersionHash","type":"BYTE"},"Data":{"name":"Data","type":"VoicData","componentTag":"pyrite-lfd-voic-data","componentProp":"voicdata"},"Terminator":{"name":"Terminator","type":"BYTE"}};

  constructor(public model: Voic){
    super(model);
  }
}
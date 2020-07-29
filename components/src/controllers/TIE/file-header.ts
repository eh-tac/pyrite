import { ControllerBase } from "../../controller-base";
import { FileHeader } from "../../model/TIE";

export class TIEFileHeaderController extends ControllerBase {
  public readonly fields: object = {"PlatformID":{"name":"PlatformID","type":"SHORT"},"NumFGs":{"name":"NumFGs","type":"SHORT"},"NumMessages":{"name":"NumMessages","type":"SHORT"},"NumGGs":{"name":"NumGGs","type":"SHORT"},"Unknown1":{"name":"Unknown1","type":"BYTE"},"Unknown2":{"name":"Unknown2","type":"BOOL"},"BriefingOfficers":{"name":"BriefingOfficers","type":"BYTE","options":"Constants.BRIEFINGOFFICERS"},"CapturedOnEject":{"name":"CapturedOnEject","type":"BOOL"},"EndOfMissionMessages":{"name":"EndOfMissionMessages","type":"CHAR"},"OtherIffNames":{"name":"OtherIffNames","type":"CHAR"}};

  constructor(public model: FileHeader){
    super(model);
  }
}
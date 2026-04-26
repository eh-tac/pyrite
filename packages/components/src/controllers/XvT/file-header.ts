import { ControllerBase } from "../../controller-base";
import { FileHeader } from "../../model/XvT";

export class XvTFileHeaderController extends ControllerBase {
  public readonly fields: object = {"PlatformID":{"name":"PlatformID","type":"SHORT"},"NumFGs":{"name":"NumFGs","type":"SHORT"},"NumMessages":{"name":"NumMessages","type":"SHORT"},"Unknown1":{"name":"Unknown1","type":"BYTE"},"Unknown2":{"name":"Unknown2","type":"BYTE"},"Unknown3":{"name":"Unknown3","type":"BOOL"},"Unknown4":{"name":"Unknown4","type":"CHAR"},"Unknown5":{"name":"Unknown5","type":"CHAR"},"MissionType":{"name":"MissionType","type":"BYTE"},"Unknown6":{"name":"Unknown6","type":"BOOL"},"TimeLimitMinutes":{"name":"TimeLimitMinutes","type":"BYTE"},"TimeLimitSeconds":{"name":"TimeLimitSeconds","type":"BYTE"}};

  constructor(public model: FileHeader){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { FileHeader } from "../../model/XWA";

export class XWAFileHeaderController extends ControllerBase {
  public readonly fields: object = {"PlatformID":{"name":"PlatformID","type":"SHORT"},"NumFGs":{"name":"NumFGs","type":"SHORT"},"NumMessages":{"name":"NumMessages","type":"SHORT"},"Unknown1":{"name":"Unknown1","type":"BOOL"},"Unknown2":{"name":"Unknown2","type":"BOOL"},"IffNames":{"name":"IffNames","type":"STR"},"RegionNames":{"name":"RegionNames","type":"STR"},"GlobalCargo":{"name":"GlobalCargo","type":"GlobalCargo","componentTag":"pyrite-xwa-global-cargo","componentProp":"globalcargo"},"GlobalGroupNames":{"name":"GlobalGroupNames","type":"STR"},"Hangar":{"name":"Hangar","type":"BYTE","options":"Constants.HANGAR"},"TimeLimitMinutes":{"name":"TimeLimitMinutes","type":"BYTE"},"EndMissionWhenComplete":{"name":"EndMissionWhenComplete","type":"BOOL"},"BriefingOfficer":{"name":"BriefingOfficer","type":"BYTE","options":"Constants.BRIEFINGOFFICER"},"BriefingLogo":{"name":"BriefingLogo","type":"BYTE","options":"Constants.BRIEFINGLOGO"},"Unknown3":{"name":"Unknown3","type":"BYTE"},"Unknown4":{"name":"Unknown4","type":"BYTE"},"Unknown5":{"name":"Unknown5","type":"BYTE"}};

  constructor(public model: FileHeader){
    super(model);
  }
}
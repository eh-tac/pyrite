import { ControllerBase } from "../../controller-base";
import { BattleIndex } from "../../model/EHBL";

export class EHBLBattleIndexController extends ControllerBase {
  public readonly fields: object = {"Platform":{"name":"Platform","type":"BYTE","options":"Constants.PLATFORM"},"EncryptionOffset":{"name":"EncryptionOffset","type":"BYTE"},"Title":{"name":"Title","type":"STR"},"MissionCount":{"name":"MissionCount","type":"BYTE"},"Unknown1":{"name":"Unknown1","type":"BYTE"},"MissionFilenames":{"name":"MissionFilenames","type":"CHAR"},"Unknown2":{"name":"Unknown2","type":"BYTE"},"Unknown3":{"name":"Unknown3","type":"BYTE"},"Unknown4":{"name":"Unknown4","type":"BYTE"},"Reserved1":{"name":"Reserved1","type":"BYTE"},"Reserved2":{"name":"Reserved2","type":"BYTE"},"Unknown5":{"name":"Unknown5","type":"BYTE"},"Unknown6":{"name":"Unknown6","type":"BYTE"},"Reserved3":{"name":"Reserved3","type":"BYTE"},"Reserved4":{"name":"Reserved4","type":"BYTE"},"BattleNumber":{"name":"BattleNumber","type":"BYTE"},"Reserved5":{"name":"Reserved5","type":"BYTE"}};

  constructor(public model: BattleIndex){
    super(model);
  }
}
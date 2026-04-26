import { ControllerBase } from "../../controller-base";
import { Team } from "../../model/XWA";

export class XWATeamController extends ControllerBase {
  public readonly fields: object = {"Reserved":{"name":"Reserved","type":"SHORT"},"Name":{"name":"Name","type":"STR"},"Allegiances":{"name":"Allegiances","type":"BYTE"},"EndOfMissionMessages":{"name":"EndOfMissionMessages","type":"CHAR"},"Unknowns":{"name":"Unknowns","type":"BYTE"},"EomVoiceIDs":{"name":"EomVoiceIDs","type":"CHAR"}};

  constructor(public model: Team){
    super(model);
  }
}
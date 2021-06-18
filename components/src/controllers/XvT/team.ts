import { ControllerBase } from "../../controller-base";
import { Team } from "../../model/XvT";

export class XvTTeamController extends ControllerBase {
  public readonly fields: object = {"Reserved":{"name":"Reserved","type":"SHORT"},"Name":{"name":"Name","type":"STR"},"Allegiances":{"name":"Allegiances","type":"BOOL"},"EndOfMissionMessages":{"name":"EndOfMissionMessages","type":"CHAR"}};

  constructor(public model: Team){
    super(model);
  }
}
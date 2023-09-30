import { ControllerBase } from "../../controller-base";
import { FileHeader } from "../../model/XW";

export class XWFileHeaderController extends ControllerBase {
  public readonly fields: object = {"Version":{"name":"Version","type":"SHORT"},"TimeLimit":{"name":"TimeLimit","type":"SHORT"},"EndState":{"name":"EndState","type":"SHORT","options":"Constants.ENDSTATE"},"Reserved":{"name":"Reserved","type":"SHORT"},"MissionLocation":{"name":"MissionLocation","type":"SHORT","options":"Constants.MISSIONLOCATION"},"CompletionMessage":{"name":"CompletionMessage","type":"STR"},"NumFGs":{"name":"NumFGs","type":"SHORT"},"NumObj":{"name":"NumObj","type":"SHORT"}};

  constructor(public model: FileHeader){
    super(model);
  }
}
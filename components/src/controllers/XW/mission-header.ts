import { ControllerBase } from "../../controller-base";
import { MissionHeader } from "../../model/XW";

export class XWMissionHeaderController extends ControllerBase {
  public readonly fields: object = {"TimeLimitMinutes":{"name":"TimeLimitMinutes","type":"SHORT"},"EndEvent":{"name":"EndEvent","type":"SHORT","options":"Constants.ENDEVENT"},"RndSeed":{"name":"RndSeed","type":"SHORT"},"MissionLocation":{"name":"MissionLocation","type":"SHORT","options":"Constants.MISSIONLOCATION"},"EndOfMissionMessages":{"name":"EndOfMissionMessages","type":"CHAR"}};

  constructor(public model: MissionHeader){
    super(model);
  }
}
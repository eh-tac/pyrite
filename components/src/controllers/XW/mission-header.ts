import { ControllerBase } from "../../controller-base";
import { MissionHeader } from "../../model/XW";

export class XWMissionHeaderController extends ControllerBase {
  public readonly fields: object = {"TimeLimitMinutes":{"name":"TimeLimitMinutes","type":"SHORT"},"EndEvent":{"name":"EndEvent","type":"SHORT"},"RndSeed":{"name":"RndSeed","type":"SHORT"},"Location":{"name":"Location","type":"SHORT"},"EndOfMissionMessages":{"name":"EndOfMissionMessages","type":"CHAR"}};

  constructor(public model: MissionHeader){
    super(model);
  }
}
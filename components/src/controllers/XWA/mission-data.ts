import { ControllerBase } from "../../controller-base";
import { MissionData } from "../../model/XWA";

export class XWAMissionDataController extends ControllerBase {
  public readonly fields: object = {"UnkA":{"name":"UnkA","type":"INT"},"AttemptCount":{"name":"AttemptCount","type":"INT"},"UnkB":{"name":"UnkB","type":"INT"},"UnkC":{"name":"UnkC","type":"INT"},"UnkD":{"name":"UnkD","type":"INT"},"WinCount":{"name":"WinCount","type":"INT"},"UnkE":{"name":"UnkE","type":"INT"},"Score":{"name":"Score","type":"INT"},"Time":{"name":"Time","type":"INT"},"UnkF":{"name":"UnkF","type":"INT"},"UnkG":{"name":"UnkG","type":"INT"},"BonusScoreTen":{"name":"BonusScoreTen","type":"INT"}};

  constructor(public model: MissionData){
    super(model);
  }
}
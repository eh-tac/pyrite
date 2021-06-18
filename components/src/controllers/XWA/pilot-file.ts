import { ControllerBase } from "../../controller-base";
import { PilotFile } from "../../model/XWA";

export class XWAPilotFileController extends ControllerBase {
  public readonly fields: object = {"Name":{"name":"Name","type":"CHAR"},"TotalScore":{"name":"TotalScore","type":"INT"},"TourOfDutyScore":{"name":"TourOfDutyScore","type":"INT"},"AzzameenScore":{"name":"AzzameenScore","type":"INT"},"SimulatorScore":{"name":"SimulatorScore","type":"INT"},"TourOfDutyKills":{"name":"TourOfDutyKills","type":"INT"},"AzzameenKills":{"name":"AzzameenKills","type":"INT"},"SimulatorKills":{"name":"SimulatorKills","type":"INT"},"TourOfDutyPartials":{"name":"TourOfDutyPartials","type":"INT"},"AzzameenPartials":{"name":"AzzameenPartials","type":"INT"},"SimulatorPartials":{"name":"SimulatorPartials","type":"INT"},"LasersHit":{"name":"LasersHit","type":"INT"},"LasersFired":{"name":"LasersFired","type":"INT"},"WarheadsHit":{"name":"WarheadsHit","type":"INT"},"WarheadsFired":{"name":"WarheadsFired","type":"INT"},"CraftLosses":{"name":"CraftLosses","type":"INT"},"MissionData":{"name":"MissionData","type":"MissionData","componentTag":"pyrite-xwa-mission-data","componentProp":"missiondata"},"CurrentRank":{"name":"CurrentRank","type":"INT"},"CurrentMedal":{"name":"CurrentMedal","type":"INT"},"BonusTen":{"name":"BonusTen","type":"INT"}};

  constructor(public model: PilotFile){
    super(model);
  }
}
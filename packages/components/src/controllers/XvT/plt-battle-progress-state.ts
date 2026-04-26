import { ControllerBase } from "../../controller-base";
import { PLTBattleProgressState } from "../../model/XvT";

export class XvTPLTBattleProgressStateController extends ControllerBase {
  public readonly fields: object = {"MissionsFlown":{"name":"MissionsFlown","type":"INT"},"CombatMissionID":{"name":"CombatMissionID","type":"INT"},"totalMissionCount":{"name":"totalMissionCount","type":"INT"},"Outcome":{"name":"Outcome","type":"INT"},"BattleListIndex":{"name":"BattleListIndex","type":"INT"},"CombatMissionListIndex":{"name":"CombatMissionListIndex","type":"INT"},"NumPlayers":{"name":"NumPlayers","type":"INT"},"totalScore":{"name":"totalScore","type":"INT"}};

  constructor(public model: PLTBattleProgressState){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { PilotFile } from "../../model/TIE";

export class TIEPilotFileController extends ControllerBase {
  public readonly fields: object = {"Start":{"name":"Start","type":"BYTE"},"PilotStatus":{"name":"PilotStatus","type":"BYTE","options":"Constants.PILOTSTATUS"},"PilotRank":{"name":"PilotRank","type":"BYTE","options":"Constants.PILOTRANK"},"PilotDifficulty":{"name":"PilotDifficulty","type":"BYTE","options":"Constants.PILOTDIFFICULTY"},"Score":{"name":"Score","type":"INT"},"SkillScore":{"name":"SkillScore","type":"SHORT"},"SecretOrder":{"name":"SecretOrder","type":"BYTE","options":"Constants.SECRETORDER"},"TrainingScores":{"name":"TrainingScores","type":"INT"},"TrainingLevels":{"name":"TrainingLevels","type":"BYTE"},"CombatScores":{"name":"CombatScores","type":"INT"},"CombatCompletes":{"name":"CombatCompletes","type":"BOOL"},"BattleStatuses":{"name":"BattleStatuses","type":"BYTE"},"BattleLastMissions":{"name":"BattleLastMissions","type":"BYTE"},"Persistence":{"name":"Persistence","type":"BYTE"},"SecretObjectives":{"name":"SecretObjectives","type":"BYTE"},"BonusObjectives":{"name":"BonusObjectives","type":"BYTE"},"BattleScores":{"name":"BattleScores","type":"INT"},"TotalKills":{"name":"TotalKills","type":"SHORT"},"TotalCaptures":{"name":"TotalCaptures","type":"SHORT"},"KillsByType":{"name":"KillsByType","type":"SHORT"},"LasersFired":{"name":"LasersFired","type":"INT"},"LasersHit":{"name":"LasersHit","type":"INT"},"WarheadsFired":{"name":"WarheadsFired","type":"SHORT"},"WarheadsHit":{"name":"WarheadsHit","type":"SHORT"},"CraftLost":{"name":"CraftLost","type":"SHORT"}};

  constructor(public model: PilotFile){
    super(model);
  }
}
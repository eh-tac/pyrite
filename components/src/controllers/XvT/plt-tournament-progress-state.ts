import { ControllerBase } from "../../controller-base";
import { PLTTournamentProgressState } from "../../model/XvT";

export class XvTPLTTournamentProgressStateController extends ControllerBase {
  public readonly fields: object = {"unknown1":{"name":"unknown1","type":"CHAR"},"completedMissionCount":{"name":"completedMissionCount","type":"INT"},"totalMissionCount":{"name":"totalMissionCount","type":"INT"},"teamRecord":{"name":"teamRecord","type":"PLTTournTeamRecord","componentTag":"pyrite-xvt-plt-tourn-team-record","componentProp":"plttournteamrecord"},"playersActive":{"name":"playersActive","type":"INT"},"teamsActive":{"name":"teamsActive","type":"INT"},"unknown2":{"name":"unknown2","type":"INT"}};

  constructor(public model: PLTTournamentProgressState){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/XvT";

export class XvTMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader","componentTag":"pyrite-xvt-file-header","componentProp":"fileheader"},"FlightGroups":{"name":"FlightGroups","type":"FlightGroup","componentTag":"pyrite-xvt-flight-group","componentProp":"flightgroup"},"Messages":{"name":"Messages","type":"Message","componentTag":"pyrite-xvt-message","componentProp":"message"},"GlobalGoals":{"name":"GlobalGoals","type":"GlobalGoal","componentTag":"pyrite-xvt-global-goal","componentProp":"globalgoal"},"Teams":{"name":"Teams","type":"Team","componentTag":"pyrite-xvt-team","componentProp":"team"},"Briefing":{"name":"Briefing","type":"Briefing","componentTag":"pyrite-xvt-briefing","componentProp":"briefing"},"FGGoalStrings":{"name":"FGGoalStrings","type":"STR"},"GlobalGoalStrings":{"name":"GlobalGoalStrings","type":"STR"},"MissionDescription":{"name":"MissionDescription","type":"STR"}};

  constructor(public model: Mission){
    super(model);
  }
}
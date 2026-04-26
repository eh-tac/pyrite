import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/XWA";

export class XWAMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader","componentTag":"pyrite-xwa-file-header","componentProp":"fileheader"},"FlightGroups":{"name":"FlightGroups","type":"FlightGroup","componentTag":"pyrite-xwa-flight-group","componentProp":"flightgroup"},"Messages":{"name":"Messages","type":"Message","componentTag":"pyrite-xwa-message","componentProp":"message"},"GlobalGoals":{"name":"GlobalGoals","type":"GlobalGoal","componentTag":"pyrite-xwa-global-goal","componentProp":"globalgoal"},"Teams":{"name":"Teams","type":"Team","componentTag":"pyrite-xwa-team","componentProp":"team"},"Briefings":{"name":"Briefings","type":"Briefing","componentTag":"pyrite-xwa-briefing","componentProp":"briefing"},"EditorNotes":{"name":"EditorNotes","type":"STR"},"BriefingStringNotes":{"name":"BriefingStringNotes","type":"STR"},"MessageNotes":{"name":"MessageNotes","type":"STR"},"EomNotes":{"name":"EomNotes","type":"STR"},"Unknown":{"name":"Unknown","type":"BYTE"},"DescriptionNotes":{"name":"DescriptionNotes","type":"STR"},"FGGoalStrings":{"name":"FGGoalStrings","type":"XWAString","componentTag":"pyrite-xwa-xwa-string","componentProp":"xwastring"},"GlobalGoalStrings":{"name":"GlobalGoalStrings","type":"XWAString","componentTag":"pyrite-xwa-xwa-string","componentProp":"xwastring"},"OrderStrings":{"name":"OrderStrings","type":"XWAString","componentTag":"pyrite-xwa-xwa-string","componentProp":"xwastring"},"Descriptions":{"name":"Descriptions","type":"STR"}};

  constructor(public model: Mission){
    super(model);
  }
}
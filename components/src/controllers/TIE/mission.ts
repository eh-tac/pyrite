import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/TIE";

export class TIEMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader","componentTag":"pyrite-tie-file-header","componentProp":"fileheader"},"FlightGroups":{"name":"FlightGroups","type":"FlightGroup","componentTag":"pyrite-tie-flight-group","componentProp":"flightgroup"},"Messages":{"name":"Messages","type":"Message","componentTag":"pyrite-tie-message","componentProp":"message"},"GlobalGoals":{"name":"GlobalGoals","type":"GlobalGoal","componentTag":"pyrite-tie-global-goal","componentProp":"globalgoal"},"Briefing":{"name":"Briefing","type":"Briefing","componentTag":"pyrite-tie-briefing","componentProp":"briefing"},"PreMissionQuestions":{"name":"PreMissionQuestions","type":"PreMissionQuestions","componentTag":"pyrite-tie-pre-mission-questions","componentProp":"premissionquestions"},"PostMissionQuestions":{"name":"PostMissionQuestions","type":"PostMissionQuestions","componentTag":"pyrite-tie-post-mission-questions","componentProp":"postmissionquestions"},"End":{"name":"End","type":"BYTE"}};

  constructor(public model: Mission){
    super(model);
  }
}
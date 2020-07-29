import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/TIE";

export class TIEMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader","componentTag":"pyrite-tie-file-header","componentProp":"file-header"},"FlightGroups":{"name":"FlightGroups","type":"FlightGroup","componentTag":"pyrite-tie-flight-group","componentProp":"flight-group"},"Messages":{"name":"Messages","type":"Message","componentTag":"pyrite-tie-message","componentProp":"message"},"GlobalGoals":{"name":"GlobalGoals","type":"GlobalGoal","componentTag":"pyrite-tie-global-goal","componentProp":"global-goal"},"Briefing":{"name":"Briefing","type":"Briefing","componentTag":"pyrite-tie-briefing","componentProp":"briefing"},"PreMissionQuestions":{"name":"PreMissionQuestions","type":"PreMissionQuestions","componentTag":"pyrite-tie-pre-mission-questions","componentProp":"pre-mission-questions"},"PostMissionQuestions":{"name":"PostMissionQuestions","type":"PostMissionQuestions","componentTag":"pyrite-tie-post-mission-questions","componentProp":"post-mission-questions"},"End":{"name":"End","type":"BYTE"}};

  constructor(public model: Mission){
    super(model);
  }
}
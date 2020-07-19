import { ControllerBase } from "../../controller-base";
import { Mission } from "../../model/TIE";

export class TIEMissionController extends ControllerBase {
  public readonly fields: object = {"FileHeader":{"name":"FileHeader","type":"FileHeader"},"FlightGroups":{"name":"FlightGroups","type":"FlightGroup"},"Messages":{"name":"Messages","type":"Message"},"GlobalGoals":{"name":"GlobalGoals","type":"GlobalGoal"},"Briefing":{"name":"Briefing","type":"Briefing"},"PreMissionQuestions":{"name":"PreMissionQuestions","type":"PreMissionQuestions"},"PostMissionQuestions":{"name":"PostMissionQuestions","type":"PostMissionQuestions"},"End":{"name":"End","type":"BYTE"}};

  constructor(public model: Mission){
    super(model);
  }
}
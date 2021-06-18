import { ControllerBase } from "../../controller-base";
import { PreMissionQuestions } from "../../model/TIE";

export class TIEPreMissionQuestionsController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Question":{"name":"Question","type":"CHAR"},"Spacer":{"name":"Spacer","type":"BYTE"},"Answer":{"name":"Answer","type":"CHAR"}};

  constructor(public model: PreMissionQuestions){
    super(model);
  }
}
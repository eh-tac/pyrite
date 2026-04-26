import { ControllerBase } from "../../controller-base";
import { PostMissionQuestions } from "../../model/TIE";

export class TIEPostMissionQuestionsController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"QuestionCondition":{"name":"QuestionCondition","type":"BYTE","options":"Constants.QUESTIONCONDITION"},"QuestionType":{"name":"QuestionType","type":"BYTE","options":"Constants.QUESTIONTYPE"},"Question":{"name":"Question","type":"CHAR"},"Spacer":{"name":"Spacer","type":"BYTE"},"Answer":{"name":"Answer","type":"CHAR"}};

  constructor(public model: PostMissionQuestions){
    super(model);
  }
}
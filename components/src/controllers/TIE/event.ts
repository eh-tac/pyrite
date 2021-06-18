import { ControllerBase } from "../../controller-base";
import { Event } from "../../model/TIE";

export class TIEEventController extends ControllerBase {
  public readonly fields: object = {"Time":{"name":"Time","type":"SHORT"},"EventType":{"name":"EventType","type":"SHORT","options":"Constants.EVENTTYPE"},"Variables":{"name":"Variables","type":"SHORT"}};

  constructor(public model: Event){
    super(model);
  }
}
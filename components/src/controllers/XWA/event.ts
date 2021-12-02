import { ControllerBase } from "../../controller-base";
import { Event } from "../../model/XWA";

export class XWAEventController extends ControllerBase {
  public readonly fields: object = {"Time":{"name":"Time","type":"SHORT"},"Type":{"name":"Type","type":"SHORT","options":"Constants.EVENTTYPE"},"Variables":{"name":"Variables","type":"SHORT"}};

  constructor(public model: Event){
    super(model);
  }
}
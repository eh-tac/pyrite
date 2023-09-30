import { ControllerBase } from "../../controller-base";
import { Page } from "../../model/XW";

export class XWPageController extends ControllerBase {
  public readonly fields: object = {"Duration":{"name":"Duration","type":"SHORT"},"EventsLength":{"name":"EventsLength","type":"SHORT"},"CoordinateSet":{"name":"CoordinateSet","type":"SHORT"},"PageType":{"name":"PageType","type":"SHORT"},"Events[EventsLength]":{"name":"Events[EventsLength]","type":"SHORT"}};

  constructor(public model: Page){
    super(model);
  }
}
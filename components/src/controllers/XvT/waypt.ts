import { ControllerBase } from "../../controller-base";
import { Waypt } from "../../model/XvT";

export class XvTWayptController extends ControllerBase {
  public readonly fields: object = {"StartPoints":{"name":"StartPoints","type":"SHORT"},"Waypoints":{"name":"Waypoints","type":"SHORT"},"Rendezvous":{"name":"Rendezvous","type":"SHORT"},"Hyperspace":{"name":"Hyperspace","type":"SHORT"},"Briefings":{"name":"Briefings","type":"SHORT"}};

  constructor(public model: Waypt){
    super(model);
  }
}
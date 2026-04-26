import { ControllerBase } from "../../controller-base";
import { BriefingHeader } from "../../model/XW";

export class XWBriefingHeaderController extends ControllerBase {
  public readonly fields: object = {"PlatformID":{"name":"PlatformID","type":"SHORT"},"IconCount":{"name":"IconCount","type":"SHORT"},"CoordinateCount":{"name":"CoordinateCount","type":"SHORT"}};

  constructor(public model: BriefingHeader){
    super(model);
  }
}
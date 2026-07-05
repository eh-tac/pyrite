import { ControllerBase } from "../../controller-base";
import { Region } from "../../model/XWA";

export class XWARegionController extends ControllerBase {
  public readonly fields: object = { Name: { name: "Name", type: "STR" }, ID: { name: "ID", type: "INT" } };

  constructor(public model: Region) {
    super(model);
  }
}

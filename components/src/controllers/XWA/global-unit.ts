import { ControllerBase } from "../../controller-base";
import { GlobalUnit } from "../../model/XWA";

export class XWAGlobalUnitController extends ControllerBase {
  public readonly fields: object = {
    Name: { name: "Name", type: "STR" },
    Leader: { name: "Leader", type: "BYTE" },
    SpecialCargoCraft: { name: "SpecialCargoCraft", type: "BYTE" },
    SpecialCargo: { name: "SpecialCargo", type: "STR" },
    RandSpecCraft: { name: "RandSpecCraft", type: "BOOL" },
  };

  constructor(public model: GlobalUnit) {
    super(model);
  }
}

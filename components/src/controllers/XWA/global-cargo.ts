import { ControllerBase } from "../../controller-base";
import { GlobalCargo } from "../../../old-assets/model/XWA";

export class XWAGlobalCargoController extends ControllerBase {
  public readonly fields: object = {
    Cargo: { name: "Cargo", type: "STR" },
    ID: { name: "ID", type: "INT" },
    Count: { name: "Count", type: "INT" },
    Type: { name: "Type", type: "BYTE" },
    Volume: { name: "Volume", type: "BYTE" },
    Value: { name: "Value", type: "BYTE" },
    Volatility: { name: "Volatility", type: "BYTE" },
  };

  constructor(public model: GlobalCargo) {
    super(model);
  }
}

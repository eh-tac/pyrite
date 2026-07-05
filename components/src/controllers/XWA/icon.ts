import { ControllerBase } from "../../controller-base";
import { Icon } from "../../model/XWA";

export class XWAIconController extends ControllerBase {
  public readonly fields: object = {
    Species: { name: "Species", type: "BYTE" },
    IFF: { name: "IFF", type: "BYTE" },
    X: { name: "X", type: "SHORT" },
    Y: { name: "Y", type: "SHORT" },
    Orientation: { name: "Orientation", type: "SHORT" },
  };

  constructor(public model: Icon) {
    super(model);
  }
}

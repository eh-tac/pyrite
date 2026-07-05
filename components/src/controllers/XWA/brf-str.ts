import { ControllerBase } from "../../controller-base";
import { BrfStr } from "../../../old-assets/model/XWA";

export class XWABrfStrController extends ControllerBase {
  public readonly fields: object = { Length: { name: "Length", type: "SHORT" }, Text: { name: "Text", type: "CHAR" } };

  constructor(public model: BrfStr) {
    super(model);
  }
}

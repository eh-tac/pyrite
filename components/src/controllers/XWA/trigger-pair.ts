import { ControllerBase } from "../../controller-base";
import { TriggerPair } from "../../../old-assets/model/XWA";

export class XWATriggerPairController extends ControllerBase {
  public readonly fields: object = {
    Trigger1: { name: "Trigger1", type: "Trigger", componentTag: "pyrite-xwa-trigger", componentProp: "trigger" },
    Trigger2: { name: "Trigger2", type: "Trigger", componentTag: "pyrite-xwa-trigger", componentProp: "trigger" },
    T1OrT2: { name: "T1OrT2", type: "BOOL" },
  };

  constructor(public model: TriggerPair) {
    super(model);
  }
}

import { ControllerBase } from "../../controller-base";
import { ViewportSetting } from "../../model/XW";

export class XWViewportSettingController extends ControllerBase {
  public readonly fields: object = {"Top":{"name":"Top","type":"SHORT"},"Left":{"name":"Left","type":"SHORT"},"Bottom":{"name":"Bottom","type":"SHORT"},"Right":{"name":"Right","type":"SHORT"},"Visible":{"name":"Visible","type":"SHORT"}};

  constructor(public model: ViewportSetting){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { Delt } from "../../model/LFD";

export class LFDDeltController extends ControllerBase {
  public readonly fields: object = {"Header":{"name":"Header","type":"Header","componentTag":"pyrite-lfd-header","componentProp":"header"},"Left":{"name":"Left","type":"SHORT"},"Top":{"name":"Top","type":"SHORT"},"Right":{"name":"Right","type":"SHORT"},"Bottom":{"name":"Bottom","type":"SHORT"},"Rows":{"name":"Rows","type":"Row","componentTag":"pyrite-lfd-row","componentProp":"row"},"Reserved":{"name":"Reserved","type":"SHORT"}};

  constructor(public model: Delt){
    super(model);
  }
}
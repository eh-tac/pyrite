import { ControllerBase } from "../../controller-base";
import { GlobalCargo } from "../../model/XWA";

export class XWAGlobalCargoController extends ControllerBase {
  public readonly fields: object = {"Cargo":{"name":"Cargo","type":"STR"},"Unknown1":{"name":"Unknown1","type":"BOOL"},"Unknown2":{"name":"Unknown2","type":"BYTE"},"Unknown3":{"name":"Unknown3","type":"BYTE"},"Unknown4":{"name":"Unknown4","type":"BYTE"},"Unknown5":{"name":"Unknown5","type":"BYTE"}};

  constructor(public model: GlobalCargo){
    super(model);
  }
}
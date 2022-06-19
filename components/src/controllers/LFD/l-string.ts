import { ControllerBase } from "../../controller-base";
import { LString } from "../../model/LFD";

export class LFDLStringController extends ControllerBase {
  public readonly fields: object = {"Length":{"name":"Length","type":"SHORT"},"Substrings":{"name":"Substrings","type":"STR"},"Reserved":{"name":"Reserved","type":"BYTE"}};

  constructor(public model: LString){
    super(model);
  }
}
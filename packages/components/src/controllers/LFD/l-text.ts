import { ControllerBase } from "../../controller-base";
import { LText } from "../../model/LFD";

export class LFDLTextController extends ControllerBase {
  public readonly fields: object = {"NumStrings":{"name":"NumStrings","type":"SHORT"},"Strings":{"name":"Strings","type":"LString","componentTag":"pyrite-lfd-l-string","componentProp":"lstring"}};

  constructor(public model: LText){
    super(model);
  }
}
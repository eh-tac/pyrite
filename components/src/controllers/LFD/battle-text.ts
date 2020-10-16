import { ControllerBase } from "../../controller-base";
import { BattleText } from "../../model/LFD";

export class LFDBattleTextController extends ControllerBase {
  public readonly fields: object = {
    Header: { name: "Header", type: "Header", componentTag: "pyrite-lfd-header", componentProp: "header" },
    NumStrings: { name: "NumStrings", type: "SHORT" },
    Names: { name: "Names", type: "LString", componentTag: "pyrite-lfd-l-string", componentProp: "lstring" },
    Titles: { name: "Titles", type: "LString", componentTag: "pyrite-lfd-l-string", componentProp: "lstring" },
    Image: { name: "Image", type: "LString", componentTag: "pyrite-lfd-l-string", componentProp: "lstring" },
    MissionFiles: {
      name: "MissionFiles",
      type: "LString",
      componentTag: "pyrite-lfd-l-string",
      componentProp: "lstring"
    },
    MissionDescriptions: {
      name: "MissionDescriptions",
      type: "LString",
      componentTag: "pyrite-lfd-l-string",
      componentProp: "lstring"
    }
  };

  constructor(public model: BattleText) {
    super(model);
  }
}

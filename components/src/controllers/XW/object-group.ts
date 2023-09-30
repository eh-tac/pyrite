import { ControllerBase } from "../../controller-base";
import { ObjectGroup } from "../../model/XW";

export class XWObjectGroupController extends ControllerBase {
  public readonly fields: object = {"Name":{"name":"Name","type":"STR"},"Cargo":{"name":"Cargo","type":"STR"},"SpecialCargo":{"name":"SpecialCargo","type":"STR"},"Reserved":{"name":"Reserved","type":"SHORT"},"ObjectType":{"name":"ObjectType","type":"SHORT"},"IFF":{"name":"IFF","type":"SHORT","options":"Constants.IFF"},"Objective":{"name":"Objective","type":"SHORT"},"NumberOfObjects":{"name":"NumberOfObjects","type":"SHORT"},"PositionX":{"name":"PositionX","type":"SHORT"},"PositionY":{"name":"PositionY","type":"SHORT"},"PositionZ":{"name":"PositionZ","type":"SHORT"},"Unknown1":{"name":"Unknown1","type":"SHORT"},"Unknown2":{"name":"Unknown2","type":"SHORT"},"Unknown3":{"name":"Unknown3","type":"SHORT"}};

  constructor(public model: ObjectGroup){
    super(model);
  }
}
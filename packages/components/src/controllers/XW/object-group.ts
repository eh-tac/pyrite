import { ControllerBase } from "../../controller-base";
import { ObjectGroup } from "../../model/XW";

export class XWObjectGroupController extends ControllerBase {
  public readonly fields: object = {"Name":{"name":"Name","type":"CHAR"},"Cargo":{"name":"Cargo","type":"CHAR"},"SpecialCargo":{"name":"SpecialCargo","type":"CHAR"},"SpecialCargoCraft":{"name":"SpecialCargoCraft","type":"SHORT"},"CraftType":{"name":"CraftType","type":"SHORT","options":"Constants.CRAFTTYPE"},"IFF":{"name":"IFF","type":"SHORT","options":"Constants.IFF"},"ObjectFormation":{"name":"ObjectFormation","type":"SHORT","options":"Constants.OBJECTFORMATION"},"NumberOfCraft":{"name":"NumberOfCraft","type":"SHORT"},"X":{"name":"X","type":"SHORT"},"Y":{"name":"Y","type":"SHORT"},"Z":{"name":"Z","type":"SHORT"},"Yaw":{"name":"Yaw","type":"SHORT"},"Pitch":{"name":"Pitch","type":"SHORT"},"Roll":{"name":"Roll","type":"SHORT"}};

  constructor(public model: ObjectGroup){
    super(model);
  }
}
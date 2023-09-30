import { ControllerBase } from "../../controller-base";
import { Icon } from "../../model/XW";

export class XWIconController extends ControllerBase {
  public readonly fields: object = {"CraftType":{"name":"CraftType","type":"SHORT"},"IFF":{"name":"IFF","type":"SHORT"},"NumberOfCraft":{"name":"NumberOfCraft","type":"SHORT"},"NumberOfWaves":{"name":"NumberOfWaves","type":"SHORT"},"Name":{"name":"Name","type":"CHAR"},"Cargo":{"name":"Cargo","type":"CHAR"},"SpecialCargo":{"name":"SpecialCargo","type":"CHAR"},"SpecialCargoCraft":{"name":"SpecialCargoCraft","type":"SHORT"},"Yaw":{"name":"Yaw","type":"SHORT"},"Pitch":{"name":"Pitch","type":"SHORT"},"Roll":{"name":"Roll","type":"SHORT"}};

  constructor(public model: Icon){
    super(model);
  }
}
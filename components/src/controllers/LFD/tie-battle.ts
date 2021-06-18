import { ControllerBase } from "../../controller-base";
import { TIEBattle } from "../../model/LFD";

export class LFDTIEBattleController extends ControllerBase {
  public readonly fields: object = {"HeaderMap":{"name":"HeaderMap","type":"Rmap","componentTag":"pyrite-lfd-rmap","componentProp":"rmap"},"BattleName":{"name":"BattleName","type":"BattleText","componentTag":"pyrite-lfd-battle-text","componentProp":"battle-text"},"BattleImage":{"name":"BattleImage","type":"Delt","componentTag":"pyrite-lfd-delt","componentProp":"delt"}};

  constructor(public model: TIEBattle){
    super(model);
  }
}
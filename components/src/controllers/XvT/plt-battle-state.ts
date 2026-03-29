import { ControllerBase } from "../../controller-base";
import { PLTBattleState } from "../../model/XvT";

export class XvTPLTBattleStateController extends ControllerBase {
  public readonly fields: object = {"ConfigRandomSeed":{"name":"ConfigRandomSeed","type":"INT"},"IsInProgressUNK":{"name":"IsInProgressUNK","type":"INT"},"ConfigBattleLength":{"name":"ConfigBattleLength","type":"INT"},"ConfigGameRandomizeLevel":{"name":"ConfigGameRandomizeLevel","type":"INT"},"saveState":{"name":"saveState","type":"PLTBattleProgressState","componentTag":"pyrite-xvt-plt-battle-progress-state","componentProp":"pltbattleprogressstate"},"unknown2":{"name":"unknown2","type":"INT"}};

  constructor(public model: PLTBattleState){
    super(model);
  }
}
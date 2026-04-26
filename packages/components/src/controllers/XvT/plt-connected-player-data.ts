import { ControllerBase } from "../../controller-base";
import { PLTConnectedPlayerData } from "../../model/XvT";

export class XvTPLTConnectedPlayerDataController extends ControllerBase {
  public readonly fields: object = {"pilotLongNameUnused":{"name":"pilotLongNameUnused","type":"CHAR"},"pilotShortName":{"name":"pilotShortName","type":"CHAR"},"fgIndex":{"name":"fgIndex","type":"INT"},"DPPlayerID":{"name":"DPPlayerID","type":"INT"},"pilotRank":{"name":"pilotRank","type":"INT"},"playerScore":{"name":"playerScore","type":"INT"},"fullKills":{"name":"fullKills","type":"INT"},"sharedKills":{"name":"sharedKills","type":"INT"},"unusedInspections":{"name":"unusedInspections","type":"INT"},"assistKills":{"name":"assistKills","type":"INT"},"losses":{"name":"losses","type":"INT"},"craftType":{"name":"craftType","type":"INT"},"optionalCraftIndex":{"name":"optionalCraftIndex","type":"INT"},"optionalWarhead":{"name":"optionalWarhead","type":"INT"},"optionalBeam":{"name":"optionalBeam","type":"INT"},"optionalCountermeasure":{"name":"optionalCountermeasure","type":"INT"},"hasDisconnectedFromHostUNK":{"name":"hasDisconnectedFromHostUNK","type":"INT"}};

  constructor(public model: PLTConnectedPlayerData){
    super(model);
  }
}
import { ControllerBase } from "../../controller-base";
import { PilotFile } from "../../model/XvT";

export class XvTPilotFileController extends ControllerBase {
  public readonly fields: object = {"Name":{"name":"Name","type":"CHAR"},"TotalScore":{"name":"TotalScore","type":"INT"},"Kills":{"name":"Kills","type":"INT"},"LasersHit":{"name":"LasersHit","type":"INT"},"LasersTotal":{"name":"LasersTotal","type":"INT"},"WarheadsHit":{"name":"WarheadsHit","type":"INT"},"WarheadsTotal":{"name":"WarheadsTotal","type":"INT"},"CraftLosses":{"name":"CraftLosses","type":"INT"},"PilotRating":{"name":"PilotRating","type":"INT","options":"Constants.PILOTRATING"},"RatingLabel":{"name":"RatingLabel","type":"CHAR"},"RebelStats":{"name":"RebelStats","type":"TeamStats","componentTag":"pyrite-xvt-team-stats","componentProp":"teamstats"},"ImperialStats":{"name":"ImperialStats","type":"TeamStats","componentTag":"pyrite-xvt-team-stats","componentProp":"teamstats"}};

  constructor(public model: PilotFile){
    super(model);
  }
}
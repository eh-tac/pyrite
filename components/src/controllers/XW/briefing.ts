import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../model/XW";

export class XWBriefingController extends ControllerBase {
  public readonly fields: object = {"BriefingHeader":{"name":"BriefingHeader","type":"BriefingHeader","componentTag":"pyrite-xw-briefing-header","componentProp":"briefingheader"},"CoordinateSet":{"name":"CoordinateSet","type":"Coordinate","componentTag":"pyrite-xw-coordinate","componentProp":"coordinate"},"IconSet":{"name":"IconSet","type":"Icon","componentTag":"pyrite-xw-icon","componentProp":"icon"},"WindowSettingsCount":{"name":"WindowSettingsCount","type":"SHORT"},"Viewports":{"name":"Viewports","type":"ViewportSetting","componentTag":"pyrite-xw-viewport-setting","componentProp":"viewportsetting"},"PageCount":{"name":"PageCount","type":"SHORT"},"Pages":{"name":"Pages","type":"Page","componentTag":"pyrite-xw-page","componentProp":"page"},"MissionHeader":{"name":"MissionHeader","type":"MissionHeader","componentTag":"pyrite-xw-mission-header","componentProp":"missionheader"},"IconExtraData":{"name":"IconExtraData","type":"BYTE"},"Tags":{"name":"Tags","type":"Tag","componentTag":"pyrite-xw-tag","componentProp":"tag"},"Strings":{"name":"Strings","type":"String","componentTag":"pyrite-xw-string","componentProp":"string"}};

  constructor(public model: Briefing){
    super(model);
  }
}
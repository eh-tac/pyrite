import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../model/XW";

export class XWBriefingController extends ControllerBase {
  public readonly fields: object = {"BriefingHeader":{"name":"BriefingHeader","type":"BriefingHeader","componentTag":"pyrite-xw-briefing-header","componentProp":"briefingheader"},"Coordinates":{"name":"Coordinates","type":"CoordinateSet","componentTag":"pyrite-xw-coordinate-set","componentProp":"coordinateset"},"IconSet":{"name":"IconSet","type":"IconSet","componentTag":"pyrite-xw-icon-set","componentProp":"iconset"},"WindowSettingsCount":{"name":"WindowSettingsCount","type":"SHORT"},"Viewports":{"name":"Viewports","type":"ViewportSetting","componentTag":"pyrite-xw-viewport-setting","componentProp":"viewportsetting"},"PageCount":{"name":"PageCount","type":"SHORT"},"Pages":{"name":"Pages","type":"Page","componentTag":"pyrite-xw-page","componentProp":"page"},"MissionHeader":{"name":"MissionHeader","type":"MissionHeader","componentTag":"pyrite-xw-mission-header","componentProp":"missionheader"},"IconExtraData":{"name":"IconExtraData","type":"BYTE"},"Tags":{"name":"Tags","type":"Tags","componentTag":"pyrite-xw-tags","componentProp":"tags"},"Strings":{"name":"Strings","type":"Strings","componentTag":"pyrite-xw-strings","componentProp":"strings"}};

  constructor(public model: Briefing){
    super(model);
  }
}
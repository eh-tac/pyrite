import { ControllerBase } from "../../controller-base";
import { FileHeader } from "../../model/XWA";

export class XWAFileHeaderController extends ControllerBase {
  public readonly fields: object = {
    PlatformID: { name: "PlatformID", type: "SHORT" },
    NumFGs: { name: "NumFGs", type: "SHORT" },
    NumMessages: { name: "NumMessages", type: "SHORT" },
    TimeLimitMin: { name: "TimeLimitMin", type: "BYTE" },
    TimeLimitSec: { name: "TimeLimitSec", type: "BYTE" },
    WinType: { name: "WinType", type: "BYTE" },
    Backdrop: { name: "Backdrop", type: "BYTE" },
    Rescue: { name: "Rescue", type: "BYTE" },
    AllWayShown: { name: "AllWayShown", type: "BYTE" },
    Vars: { name: "Vars", type: "BYTE" },
    IffNames: { name: "IffNames", type: "STR" },
    Regions: { name: "Regions", type: "Region", componentTag: "pyrite-xwa-region", componentProp: "region" },
    GlobalCargo: {
      name: "GlobalCargo",
      type: "GlobalCargo",
      componentTag: "pyrite-xwa-global-cargo",
      componentProp: "globalcargo",
    },
    GlobalGroups: {
      name: "GlobalGroups",
      type: "GlobalUnit",
      componentTag: "pyrite-xwa-global-unit",
      componentProp: "globalunit",
    },
    GlobalUnits: {
      name: "GlobalUnits",
      type: "GlobalUnit",
      componentTag: "pyrite-xwa-global-unit",
      componentProp: "globalunit",
    },
    Hangar: { name: "Hangar", type: "BYTE", options: "Constants.HANGAR" },
    GoalsUnimportant: { name: "GoalsUnimportant", type: "BOOL" },
    TimeLimitMinutes: { name: "TimeLimitMinutes", type: "BYTE" },
    EndMissionWhenComplete: { name: "EndMissionWhenComplete", type: "BOOL" },
    BriefingOfficer: { name: "BriefingOfficer", type: "BYTE", options: "Constants.BRIEFINGOFFICER" },
    BriefingLogo: { name: "BriefingLogo", type: "BYTE", options: "Constants.BRIEFINGLOGO" },
    BriefingOfficerEntryLine: { name: "BriefingOfficerEntryLine", type: "BYTE" },
    SecondaryVersion: { name: "SecondaryVersion", type: "BYTE" },
    WinOfficer: { name: "WinOfficer", type: "BYTE", options: "Constants.BRIEFINGOFFICER" },
    FailOfficer: { name: "FailOfficer", type: "BYTE", options: "Constants.BRIEFINGOFFICER" },
  };

  constructor(public model: FileHeader) {
    super(model);
  }
}

import { ControllerBase } from "../../controller-base";
import { Briefing } from "../../../old-assets/model/XWA";

export class XWABriefingController extends ControllerBase {
  public readonly fields: object = {
    RunningTime: { name: "RunningTime", type: "SHORT" },
    CurrentTime: { name: "CurrentTime", type: "SHORT" },
    StartLength: { name: "StartLength", type: "SHORT" },
    EventsLength: { name: "EventsLength", type: "SHORT" },
    Tile: { name: "Tile", type: "SHORT" },
    Events: { name: "Events", type: "Event", componentTag: "pyrite-xwa-event", componentProp: "event" },
    Icons: { name: "Icons", type: "Icon", componentTag: "pyrite-xwa-icon", componentProp: "icon" },
    ViewedByTeam: { name: "ViewedByTeam", type: "BOOL" },
    Tags: { name: "Tags", type: "BrfStr", componentTag: "pyrite-xwa-brf-str", componentProp: "brfstr" },
    Strings: { name: "Strings", type: "BrfStr", componentTag: "pyrite-xwa-brf-str", componentProp: "brfstr" },
  };

  constructor(public model: Briefing) {
    super(model);
  }
}

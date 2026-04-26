import { Component, Prop, Host, h, JSX, Element, Watch } from "@stencil/core";
import { Mission } from "../../../model/XvT";
import { XvTMissionController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-mission",
  styleUrl: "mission.scss",
  shadow: false
})
export class XvTMissionComponent {
  @Element() public el: HTMLElement;
  @Prop() public mission: Mission;

  private controller: XvTMissionController;

  public componentWillLoad(): void {
    this.init();
  }

  @Watch("mission")
  public init(): void {
    if (this.mission && !this.controller) {
      this.controller = new XvTMissionController(this.mission);
    }
  }

  public render(): JSX.Element {
    if (!this.controller) {
      return "";
    }
    return (
      <Host>
        <Field {...this.controller.getProps("FileHeader")} />
        <Field {...this.controller.getProps("FlightGroups")} />
        <Field {...this.controller.getProps("Messages")} />
        <Field {...this.controller.getProps("GlobalGoals")} />
        <Field {...this.controller.getProps("Teams")} />
        <Field {...this.controller.getProps("Briefing")} />
        <Field {...this.controller.getProps("FGGoalStrings")} />
        <Field {...this.controller.getProps("GlobalGoalStrings")} />
        <Field {...this.controller.getProps("MissionDescription")} />
      </Host>
    );
  }
}

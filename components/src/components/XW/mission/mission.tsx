import { Component, Prop, Host, h, JSX, Element, Watch } from "@stencil/core";
import { Mission } from "../../../model/XW";
import { XWMissionController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-mission",
  styleUrl: "mission.scss",
  shadow: false
})
export class XWMissionComponent {
  @Element() public el: HTMLElement;
  @Prop() public mission: Mission;

  private controller: XWMissionController;

  public componentWillLoad(): void {
    this.init();
  }

  @Watch("mission")
  public init(): void {
    if (this.mission) {
      this.controller = new XWMissionController(this.mission);
    }
  }

  public render(): JSX.Element {
    if (!this.controller) {
      return "Loading...";
    }
    return (
      <Host>
        <Field {...this.controller.getProps("FileHeader")} />
        <Field {...this.controller.getProps("Unnamed")} />
      </Host>
    );
  }
}

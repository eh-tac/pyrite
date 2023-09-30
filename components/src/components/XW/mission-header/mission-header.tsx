import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { MissionHeader } from "../../../model/XW";
import { XWMissionHeaderController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-mission-header",
  styleUrl: "mission-header.scss",
  shadow: false
})
export class XWMissionHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public missionheader: MissionHeader;

  private controller: XWMissionHeaderController;

  public componentWillLoad(): void {
    this.controller = new XWMissionHeaderController(this.missionheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('TimeLimitMinutes')} />
        <Field {...this.controller.getProps('EndEvent')} />
        <Field {...this.controller.getProps('RndSeed')} />
        <Field {...this.controller.getProps('Location')} />
        <Field {...this.controller.getProps('EndOfMissionMessages')} />
      </Host>
    )
  }
}
  
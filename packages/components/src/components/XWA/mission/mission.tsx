import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Mission } from "../../../model/XWA";
import { XWAMissionController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-mission",
  styleUrl: "mission.scss",
  shadow: false
})
export class XWAMissionComponent {
  @Element() public el: HTMLElement;
  @Prop() public mission: Mission;

  private controller: XWAMissionController;

  public componentWillLoad(): void {
    this.controller = new XWAMissionController(this.mission);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Header')} />
        <Field {...this.controller.getProps('FlightGroups')} />
        <Field {...this.controller.getProps('Messages')} />
        <Field {...this.controller.getProps('GlobalGoals')} />
        <Field {...this.controller.getProps('Teams')} />
        <Field {...this.controller.getProps('Briefings')} />
        <Field {...this.controller.getProps('EditorNotes')} />
        <Field {...this.controller.getProps('BriefingStringNotes')} />
        <Field {...this.controller.getProps('MessageNotes')} />
        <Field {...this.controller.getProps('EomNotes')} />
        <Field {...this.controller.getProps('Unknown')} />
        <Field {...this.controller.getProps('DescriptionNotes')} />
        <Field {...this.controller.getProps('FGGoalStrings')} />
        <Field {...this.controller.getProps('GlobalGoalStrings')} />
        <Field {...this.controller.getProps('OrderStrings')} />
        <Field {...this.controller.getProps('Descriptions')} />
      </Host>
    )
  }
}
  
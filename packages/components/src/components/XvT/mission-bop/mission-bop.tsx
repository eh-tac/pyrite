import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { MissionBOP } from "../../../model/XvT";
import { XvTMissionBOPController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-mission-bop",
  styleUrl: "mission-bop.scss",
  shadow: false
})
export class XvTMissionBOPComponent {
  @Element() public el: HTMLElement;
  @Prop() public missionbop: MissionBOP;

  private controller: XvTMissionBOPController;

  public componentWillLoad(): void {
    this.controller = new XvTMissionBOPController(this.missionbop);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('FileHeader')} />
        <Field {...this.controller.getProps('FlightGroups')} />
        <Field {...this.controller.getProps('Messages')} />
        <Field {...this.controller.getProps('GlobalGoals')} />
        <Field {...this.controller.getProps('Teams')} />
        <Field {...this.controller.getProps('Briefing')} />
        <Field {...this.controller.getProps('FGGoalStrings')} />
        <Field {...this.controller.getProps('GlobalGoalStrings')} />
        <Field {...this.controller.getProps('MissionDescriptions')} />
      </Host>
    )
  }
}
  
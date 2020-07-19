import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Mission } from "../../../model/TIE";
import { TIEMissionController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-tie-mission",
  styleUrl: "mission.scss",
  shadow: false
})
export class TIEMissionComponent {
  @Element() public el: HTMLElement;
  @Prop() public mission: Mission;

  private controller: TIEMissionController;

  public componentWillLoad(): void {
    this.controller = new TIEMissionController(this.mission);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('FileHeader')} />
        <Field {...this.controller.getProps('FlightGroups')} />
        <Field {...this.controller.getProps('Messages')} />
        <Field {...this.controller.getProps('GlobalGoals')} />
        <Field {...this.controller.getProps('Briefing')} />
        <Field {...this.controller.getProps('PreMissionQuestions')} />
        <Field {...this.controller.getProps('PostMissionQuestions')} />
        <Field {...this.controller.getProps('End')} />
      </Host>
    )
  }
}
  
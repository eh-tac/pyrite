import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { MissionData } from "../../../model/XvT";
import { XvTMissionDataController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-mission-data",
  styleUrl: "mission-data.scss",
  shadow: false
})
export class XvTMissionDataComponent {
  @Element() public el: HTMLElement;
  @Prop() public missiondata: MissionData;

  private controller: XvTMissionDataController;

  public componentWillLoad(): void {
    this.controller = new XvTMissionDataController(this.missiondata);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('AttemptCount')} />
        <Field {...this.controller.getProps('WinCount')} />
        <Field {...this.controller.getProps('LossCount')} />
        <Field {...this.controller.getProps('BestScore')} />
        <Field {...this.controller.getProps('BestTime')} />
        <Field {...this.controller.getProps('BestTimeSecond')} />
        <Field {...this.controller.getProps('BestRating')} />
        <Field {...this.controller.getProps('Something')} />
        <Field {...this.controller.getProps('Other')} />
      </Host>
    )
  }
}
  
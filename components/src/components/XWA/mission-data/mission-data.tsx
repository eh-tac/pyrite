import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { MissionData } from "../../../model/XWA";
import { XWAMissionDataController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-mission-data",
  styleUrl: "mission-data.scss",
  shadow: false
})
export class XWAMissionDataComponent {
  @Element() public el: HTMLElement;
  @Prop() public missiondata: MissionData;

  private controller: XWAMissionDataController;

  public componentWillLoad(): void {
    this.controller = new XWAMissionDataController(this.missiondata);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('AttemptCount')} />
        <Field {...this.controller.getProps('WinCount')} />
        <Field {...this.controller.getProps('Score')} />
        <Field {...this.controller.getProps('Time')} />
        <Field {...this.controller.getProps('BonusScoreTen')} />
      </Host>
    )
  }
}
  
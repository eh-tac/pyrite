import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTTeamResultRecord } from "../../../model/XvT";
import { XvTPLTTeamResultRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-team-result-record",
  styleUrl: "plt-team-result-record.scss",
  shadow: false
})
export class XvTPLTTeamResultRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltteamresultrecord: PLTTeamResultRecord;

  private controller: XvTPLTTeamResultRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTTeamResultRecordController(this.pltteamresultrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('totalMissionScore')} />
        <Field {...this.controller.getProps('isMissionComplete')} />
        <Field {...this.controller.getProps('unknown0x8')} />
        <Field {...this.controller.getProps('timeMissionComplete')} />
        <Field {...this.controller.getProps('fullKills')} />
        <Field {...this.controller.getProps('sharedKills')} />
        <Field {...this.controller.getProps('losses')} />
      </Host>
    )
  }
}
  
import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTMissionSPRecord } from "../../../model/XvT";
import { XvTPLTMissionSPRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-mission-sp-record",
  styleUrl: "plt-mission-sp-record.scss",
  shadow: false
})
export class XvTPLTMissionSPRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltmissionsprecord: PLTMissionSPRecord;

  private controller: XvTPLTMissionSPRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTMissionSPRecordController(this.pltmissionsprecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('unknown0x0')} />
        <Field {...this.controller.getProps('totalCountFlown')} />
        <Field {...this.controller.getProps('totalCountVictory')} />
        <Field {...this.controller.getProps('totalCountFailure')} />
        <Field {...this.controller.getProps('bestScore')} />
        <Field {...this.controller.getProps('bestTimeAsSeconds')} />
        <Field {...this.controller.getProps('bestFinishRank')} />
        <Field {...this.controller.getProps('bestEvaluationBadge')} />
        <Field {...this.controller.getProps('bestWinningMargin')} />
      </Host>
    )
  }
}
  
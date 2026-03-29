import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTMissionMPRecord } from "../../../model/XvT";
import { XvTPLTMissionMPRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-mission-mp-record",
  styleUrl: "plt-mission-mp-record.scss",
  shadow: false
})
export class XvTPLTMissionMPRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltmissionmprecord: PLTMissionMPRecord;

  private controller: XvTPLTMissionMPRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTMissionMPRecordController(this.pltmissionmprecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('unknown0x0')} />
        <Field {...this.controller.getProps('totalCountFlown')} />
        <Field {...this.controller.getProps('totalCountFinishedFirst')} />
        <Field {...this.controller.getProps('totalCountFinishedSecond')} />
        <Field {...this.controller.getProps('totalCountFinishedThird')} />
        <Field {...this.controller.getProps('totalCountVictory')} />
        <Field {...this.controller.getProps('totalCountFailure')} />
        <Field {...this.controller.getProps('bestScore')} />
        <Field {...this.controller.getProps('bestTimeAsSeconds')} />
        <Field {...this.controller.getProps('bestFinishPlace')} />
        <Field {...this.controller.getProps('bestEvaluationBadge')} />
        <Field {...this.controller.getProps('bestWinningMargin')} />
      </Host>
    )
  }
}
  
import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTTournMPRecord } from "../../../model/XvT";
import { XvTPLTTournMPRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-tourn-mp-record",
  styleUrl: "plt-tourn-mp-record.scss",
  shadow: false
})
export class XvTPLTTournMPRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public plttournmprecord: PLTTournMPRecord;

  private controller: XvTPLTTournMPRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTTournMPRecordController(this.plttournmprecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('unknown0x0')} />
        <Field {...this.controller.getProps('totalCountFlown')} />
        <Field {...this.controller.getProps('numberOfFinishesAnyUNK')} />
        <Field {...this.controller.getProps('numberOfFinishesFirst')} />
        <Field {...this.controller.getProps('numberOfFinishesSecond')} />
        <Field {...this.controller.getProps('numberOfFinishesThird')} />
        <Field {...this.controller.getProps('bestScore')} />
        <Field {...this.controller.getProps('bestFinish')} />
        <Field {...this.controller.getProps('unknown0x20')} />
        <Field {...this.controller.getProps('bestEvaluationMedal')} />
        <Field {...this.controller.getProps('bestFinishPointMargin')} />
      </Host>
    )
  }
}
  
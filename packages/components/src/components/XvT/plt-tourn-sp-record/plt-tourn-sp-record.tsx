import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTTournSPRecord } from "../../../model/XvT";
import { XvTPLTTournSPRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-tourn-sp-record",
  styleUrl: "plt-tourn-sp-record.scss",
  shadow: false
})
export class XvTPLTTournSPRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public plttournsprecord: PLTTournSPRecord;

  private controller: XvTPLTTournSPRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTTournSPRecordController(this.plttournsprecord);
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
        <Field {...this.controller.getProps('bestEvaluationMedal')} />
        <Field {...this.controller.getProps('bestFinishPointMargin')} />
      </Host>
    )
  }
}
  
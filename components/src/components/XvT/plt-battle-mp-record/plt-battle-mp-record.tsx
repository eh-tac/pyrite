import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTBattleMPRecord } from "../../../model/XvT";
import { XvTPLTBattleMPRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-battle-mp-record",
  styleUrl: "plt-battle-mp-record.scss",
  shadow: false
})
export class XvTPLTBattleMPRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltbattlemprecord: PLTBattleMPRecord;

  private controller: XvTPLTBattleMPRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTBattleMPRecordController(this.pltbattlemprecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('unknown0x0')} />
        <Field {...this.controller.getProps('totalCountFlown')} />
        <Field {...this.controller.getProps('totalCountVictory')} />
        <Field {...this.controller.getProps('totalCountFailure')} />
        <Field {...this.controller.getProps('totalCount10MissionMarathonUNK')} />
        <Field {...this.controller.getProps('bestScore')} />
        <Field {...this.controller.getProps('unknown0x18')} />
        <Field {...this.controller.getProps('unknown0x1C')} />
        <Field {...this.controller.getProps('bestEvaluationMedal')} />
        <Field {...this.controller.getProps('bestVictoryMargin')} />
      </Host>
    )
  }
}
  
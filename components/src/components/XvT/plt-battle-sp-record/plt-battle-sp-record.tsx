import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTBattleSPRecord } from "../../../model/XvT";
import { XvTPLTBattleSPRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-battle-sp-record",
  styleUrl: "plt-battle-sp-record.scss",
  shadow: false
})
export class XvTPLTBattleSPRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltbattlesprecord: PLTBattleSPRecord;

  private controller: XvTPLTBattleSPRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTBattleSPRecordController(this.pltbattlesprecord);
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
        <Field {...this.controller.getProps('bestEvaluationMedal')} />
        <Field {...this.controller.getProps('bestVictoryMargin')} />
      </Host>
    )
  }
}
  
import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PL2DebriefRecord } from "../../../model/XvT";
import { XvTPL2DebriefRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pl-2-debrief-record",
  styleUrl: "pl-2-debrief-record.scss",
  shadow: false
})
export class XvTPL2DebriefRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pl2debriefrecord: PL2DebriefRecord;

  private controller: XvTPL2DebriefRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPL2DebriefRecordController(this.pl2debriefrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('UnknownRecord1')} />
        <Field {...this.controller.getProps('UnknownRecord2')} />
        <Field {...this.controller.getProps('UnknownRecord3')} />
        <Field {...this.controller.getProps('enemyKillsEXX')} />
        <Field {...this.controller.getProps('friendlyKillsEXX')} />
        <Field {...this.controller.getProps('totalKillCountByCraftType')} />
        <Field {...this.controller.getProps('FullKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('SharedKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('AssistKillsOnPlayerRank')} />
        <Field {...this.controller.getProps('FullKillsOnAIRank')} />
        <Field {...this.controller.getProps('SharedKillsOnAIRank')} />
        <Field {...this.controller.getProps('AssistKillsOnAIRank')} />
        <Field {...this.controller.getProps('NumHiddenCargoFoundEXX')} />
        <Field {...this.controller.getProps('NumCannonHitsEXX')} />
        <Field {...this.controller.getProps('NumCannonFiredEXX')} />
        <Field {...this.controller.getProps('NumWarheadHitsEXX')} />
        <Field {...this.controller.getProps('NumWarheadFiredEXX')} />
        <Field {...this.controller.getProps('NumCraftLossesEXX')} />
        <Field {...this.controller.getProps('CraftLossesFromCollisionEXX')} />
        <Field {...this.controller.getProps('CraftLossesFromStarshipEXX')} />
        <Field {...this.controller.getProps('CraftLossesFromMineEXX')} />
        <Field {...this.controller.getProps('LossesFromPlayerRank')} />
        <Field {...this.controller.getProps('LossesFromAIRank')} />
      </Host>
    )
  }
}
  
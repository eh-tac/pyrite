import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PL2CampaignRecord } from "../../../model/XvT";
import { XvTPL2CampaignRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pl-2-campaign-record",
  styleUrl: "pl-2-campaign-record.scss",
  shadow: false
})
export class XvTPL2CampaignRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pl2campaignrecord: PL2CampaignRecord;

  private controller: XvTPL2CampaignRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPL2CampaignRecordController(this.pl2campaignrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('IDNumber')} />
        <Field {...this.controller.getProps('totalCountFlown')} />
        <Field {...this.controller.getProps('isMissionCompleteWithoutCheat')} />
        <Field {...this.controller.getProps('bestScore')} />
        <Field {...this.controller.getProps('bestEvaluationBadge')} />
        <Field {...this.controller.getProps('bestTimeAsSeconds')} />
        <Field {...this.controller.getProps('isMissionComplete')} />
        <Field {...this.controller.getProps('UIFrameTimerHelper')} />
      </Host>
    )
  }
}
  
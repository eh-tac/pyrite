import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PL2CampaignStatusSPRecord } from "../../../model/XvT";
import { XvTPL2CampaignStatusSPRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pl-2-campaign-status-sp-record",
  styleUrl: "pl-2-campaign-status-sp-record.scss",
  shadow: false
})
export class XvTPL2CampaignStatusSPRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pl2campaignstatussprecord: PL2CampaignStatusSPRecord;

  private controller: XvTPL2CampaignStatusSPRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPL2CampaignStatusSPRecordController(this.pl2campaignstatussprecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('unknown0x0')} />
        <Field {...this.controller.getProps('isStartedUNK')} />
        <Field {...this.controller.getProps('missionNumber')} />
        <Field {...this.controller.getProps('isFinished')} />
        <Field {...this.controller.getProps('bestScore')} />
        <Field {...this.controller.getProps('unknown0x14')} />
        <Field {...this.controller.getProps('unknown0x18')} />
        <Field {...this.controller.getProps('unknown0x1C')} />
        <Field {...this.controller.getProps('unknown0x20')} />
      </Host>
    )
  }
}
  
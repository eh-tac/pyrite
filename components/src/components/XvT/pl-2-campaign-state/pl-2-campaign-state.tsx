import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PL2CampaignState } from "../../../model/XvT";
import { XvTPL2CampaignStateController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pl-2-campaign-state",
  styleUrl: "pl-2-campaign-state.scss",
  shadow: false
})
export class XvTPL2CampaignStateComponent {
  @Element() public el: HTMLElement;
  @Prop() public pl2campaignstate: PL2CampaignState;

  private controller: XvTPL2CampaignStateController;

  public componentWillLoad(): void {
    this.controller = new XvTPL2CampaignStateController(this.pl2campaignstate);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('ConfigRandomSeed')} />
        <Field {...this.controller.getProps('IsInProgressUNK')} />
        <Field {...this.controller.getProps('ConfigGameRandomizeLevel')} />
        <Field {...this.controller.getProps('saveState')} />
        <Field {...this.controller.getProps('unknown2')} />
      </Host>
    )
  }
}
  
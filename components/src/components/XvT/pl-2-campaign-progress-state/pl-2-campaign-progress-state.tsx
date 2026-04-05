import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PL2CampaignProgressState } from "../../../model/XvT";
import { XvTPL2CampaignProgressStateController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pl-2-campaign-progress-state",
  styleUrl: "pl-2-campaign-progress-state.scss",
  shadow: false
})
export class XvTPL2CampaignProgressStateComponent {
  @Element() public el: HTMLElement;
  @Prop() public pl2campaignprogressstate: PL2CampaignProgressState;

  private controller: XvTPL2CampaignProgressStateController;

  public componentWillLoad(): void {
    this.controller = new XvTPL2CampaignProgressStateController(this.pl2campaignprogressstate);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('unknown1')} />
        <Field {...this.controller.getProps('CurrentMissionNumber')} />
        <Field {...this.controller.getProps('totalMissionCount')} />
        <Field {...this.controller.getProps('CurrentMissionComplete')} />
        <Field {...this.controller.getProps('PlayerCount')} />
        <Field {...this.controller.getProps('totalScore')} />
      </Host>
    )
  }
}
  
import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTTournTeamRecord } from "../../../model/XvT";
import { XvTPLTTournTeamRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-tourn-team-record",
  styleUrl: "plt-tourn-team-record.scss",
  shadow: false
})
export class XvTPLTTournTeamRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public plttournteamrecord: PLTTournTeamRecord;

  private controller: XvTPLTTournTeamRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTTournTeamRecordController(this.plttournteamrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('teamParticipationState')} />
        <Field {...this.controller.getProps('totalTeamScore')} />
        <Field {...this.controller.getProps('numberOfMeleeRankingsFirst')} />
        <Field {...this.controller.getProps('numberOfMeleeRankingsSecond')} />
        <Field {...this.controller.getProps('numberOfMeleeRankingsThird')} />
      </Host>
    )
  }
}
  
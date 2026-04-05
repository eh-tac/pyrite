import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTEarnedMedalRecord } from "../../../model/XvT";
import { XvTPLTEarnedMedalRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-earned-medal-record",
  styleUrl: "plt-earned-medal-record.scss",
  shadow: false
})
export class XvTPLTEarnedMedalRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltearnedmedalrecord: PLTEarnedMedalRecord;

  private controller: XvTPLTEarnedMedalRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTEarnedMedalRecordController(this.pltearnedmedalrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('meleePlaqueCount')} />
        <Field {...this.controller.getProps('tournamentPlaqueCount')} />
        <Field {...this.controller.getProps('exerciseBadgeCount')} />
        <Field {...this.controller.getProps('battleMedalCount')} />
      </Host>
    )
  }
}
  
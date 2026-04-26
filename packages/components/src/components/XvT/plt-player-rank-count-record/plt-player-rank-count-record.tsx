import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTPlayerRankCountRecord } from "../../../model/XvT";
import { XvTPLTPlayerRankCountRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-player-rank-count-record",
  styleUrl: "plt-player-rank-count-record.scss",
  shadow: false
})
export class XvTPLTPlayerRankCountRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltplayerrankcountrecord: PLTPlayerRankCountRecord;

  private controller: XvTPLTPlayerRankCountRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTPlayerRankCountRecordController(this.pltplayerrankcountrecord);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('exercise')} />
        <Field {...this.controller.getProps('melee')} />
        <Field {...this.controller.getProps('combat')} />
      </Host>
    )
  }
}
  
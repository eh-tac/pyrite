import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTAIRankCountRecord } from "../../../model/XvT";
import { XvTPLTAIRankCountRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-pltai-rank-count-record",
  styleUrl: "pltai-rank-count-record.scss",
  shadow: false
})
export class XvTPLTAIRankCountRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltairankcountrecord: PLTAIRankCountRecord;

  private controller: XvTPLTAIRankCountRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTAIRankCountRecordController(this.pltairankcountrecord);
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
  
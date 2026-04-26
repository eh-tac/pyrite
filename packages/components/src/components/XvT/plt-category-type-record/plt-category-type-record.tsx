import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PLTCategoryTypeRecord } from "../../../model/XvT";
import { XvTPLTCategoryTypeRecordController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-plt-category-type-record",
  styleUrl: "plt-category-type-record.scss",
  shadow: false
})
export class XvTPLTCategoryTypeRecordComponent {
  @Element() public el: HTMLElement;
  @Prop() public pltcategorytyperecord: PLTCategoryTypeRecord;

  private controller: XvTPLTCategoryTypeRecordController;

  public componentWillLoad(): void {
    this.controller = new XvTPLTCategoryTypeRecordController(this.pltcategorytyperecord);
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
  
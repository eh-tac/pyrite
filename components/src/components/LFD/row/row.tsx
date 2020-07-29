import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Row } from "../../../model/LFD";
import { LFDRowController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-row",
  styleUrl: "row.scss",
  shadow: false
})
export class LFDRowComponent {
  @Element() public el: HTMLElement;
  @Prop() public row: Row;

  private controller: LFDRowController;

  public componentWillLoad(): void {
    this.controller = new LFDRowController(this.row);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Length')} />
        <Field {...this.controller.getProps('Left')} />
        <Field {...this.controller.getProps('Top')} />
      </Host>
    )
  }
}
  
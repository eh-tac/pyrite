import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Header } from "../../../model/LFD";
import { LFDHeaderController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-header",
  styleUrl: "header.scss",
  shadow: false
})
export class LFDHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public header: Header;

  private controller: LFDHeaderController;

  public componentWillLoad(): void {
    this.controller = new LFDHeaderController(this.header);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Type")} />
        <Field {...this.controller.getProps("Name")} />
        <Field {...this.controller.getProps("Length")} />
      </Host>
    );
  }
}

import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { LString } from "../../../model/LFD";
import { LFDLStringController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-l-string",
  styleUrl: "l-string.scss",
  shadow: false
})
export class LFDLStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public lstring: LString;

  private controller: LFDLStringController;

  public componentWillLoad(): void {
    this.controller = new LFDLStringController(this.lstring);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Length')} />
        <Field {...this.controller.getProps('Text')} />
        <Field {...this.controller.getProps('Reserved')} />
      </Host>
    )
  }
}
  
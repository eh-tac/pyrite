import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { LText } from "../../../model/LFD";
import { LFDLTextController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-l-text",
  styleUrl: "l-text.scss",
  shadow: false
})
export class LFDLTextComponent {
  @Element() public el: HTMLElement;
  @Prop() public ltext: LText;

  private controller: LFDLTextController;

  public componentWillLoad(): void {
    this.controller = new LFDLTextController(this.ltext);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('NumStrings')} />
        <Field {...this.controller.getProps('Strings')} />
      </Host>
    )
  }
}
  
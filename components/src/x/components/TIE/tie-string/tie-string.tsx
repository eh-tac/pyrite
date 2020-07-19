import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { TIEString } from "../../../model/TIE";
import { TIETIEStringController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-tie-tie-string",
  styleUrl: "tie-string.scss",
  shadow: false
})
export class TIETIEStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public tiestring: TIEString;

  private controller: TIETIEStringController;

  public componentWillLoad(): void {
    this.controller = new TIETIEStringController(this.tiestring);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Length')} />
        <Field {...this.controller.getProps('Text')} />
      </Host>
    )
  }
}
  
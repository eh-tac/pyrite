import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { TIEString } from "../../../model/TIE";
import { TIEStringController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-tie-string",
  styleUrl: "tie-string.scss",
  shadow: false
})
export class TIEStringComponent {
  @Element() public el: HTMLElement;
  @Prop() public tiestring: TIEString;

  private controller: TIEStringController;

  public componentWillLoad(): void {
    this.controller = new TIEStringController(this.tiestring);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Length")} />
        <Field {...this.controller.getProps("Text")} />
      </Host>
    );
  }
}

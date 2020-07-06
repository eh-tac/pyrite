import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { TIEString } from "../../../model/TIE";
import { TIETIEStringController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-tie-string",
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
      {this.controller.render("Length")}
      {this.controller.render("Text")}        
      </Host>
    )
  }
}
  
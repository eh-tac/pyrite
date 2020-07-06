import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Tag } from "../../../model/TIE";
import { TIETagController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-tag",
  styleUrl: "tag.scss",
  shadow: false
})
export class TIETagComponent {
  @Element() public el: HTMLElement;
  @Prop() public tag: Tag;

  private controller: TIETagController;

  public componentWillLoad(): void {
    this.controller = new TIETagController(this.tag);
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
  
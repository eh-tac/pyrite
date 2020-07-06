import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Waypt } from "../../../model/TIE";
import { TIEWayptController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-waypt",
  styleUrl: "waypt.scss",
  shadow: false
})
export class TIEWayptComponent {
  @Element() public el: HTMLElement;
  @Prop() public waypt: Waypt;

  private controller: TIEWayptController;

  public componentWillLoad(): void {
    this.controller = new TIEWayptController(this.waypt);
  }

  public render(): JSX.Element {
    return (
      <Host>
      {this.controller.render("StartPoints")}
      {this.controller.render("Waypoints")}
      {this.controller.render("Rendezvous")}
      {this.controller.render("Hyperspace")}
      {this.controller.render("Briefing")}        
      </Host>
    )
  }
}
  
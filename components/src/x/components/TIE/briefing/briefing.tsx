import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Briefing } from "../../../model/TIE";
import { TIEBriefingController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-briefing",
  styleUrl: "briefing.scss",
  shadow: false
})
export class TIEBriefingComponent {
  @Element() public el: HTMLElement;
  @Prop() public briefing: Briefing;

  private controller: TIEBriefingController;

  public componentWillLoad(): void {
    this.controller = new TIEBriefingController(this.briefing);
  }

  public render(): JSX.Element {
    return (
      <Host>
      {this.controller.render("RunningTime")}
      {this.controller.render("Unknown")}
      {this.controller.render("StartLength")}
      {this.controller.render("EventsLength")}
      {this.controller.render("Events")}
      {this.controller.render("Tags")}
      {this.controller.render("Strings")}        
      </Host>
    )
  }
}
  
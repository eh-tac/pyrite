import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Mission } from "../../../model/TIE";
import { TIEMissionController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-mission",
  styleUrl: "mission.scss",
  shadow: false
})
export class TIEMissionComponent {
  @Element() public el: HTMLElement;
  @Prop() public mission: Mission;

  private controller: TIEMissionController;

  public componentWillLoad(): void {
    this.controller = new TIEMissionController(this.mission);
  }

  public render(): JSX.Element {
    return (
      <Host>
      {this.controller.render("FileHeader")}
      {this.controller.render("FlightGroups")}
      {this.controller.render("Messages")}
      {this.controller.render("GlobalGoals")}
      {this.controller.render("Briefing")}
      {this.controller.render("PreMissionQuestions")}
      {this.controller.render("PostMissionQuestions")}
      {this.controller.render("End")}        
      </Host>
    )
  }
}
  
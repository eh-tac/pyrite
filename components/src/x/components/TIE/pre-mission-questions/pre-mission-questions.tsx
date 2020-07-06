import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PreMissionQuestions } from "../../../model/TIE";
import { TIEPreMissionQuestionsController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-pre-mission-questions",
  styleUrl: "pre-mission-questions.scss",
  shadow: false
})
export class TIEPreMissionQuestionsComponent {
  @Element() public el: HTMLElement;
  @Prop() public premissionquestions: PreMissionQuestions;

  private controller: TIEPreMissionQuestionsController;

  public componentWillLoad(): void {
    this.controller = new TIEPreMissionQuestionsController(this.premissionquestions);
  }

  public render(): JSX.Element {
    return (
      <Host>
      {this.controller.render("Length")}
      {this.controller.render("Question")}
      {this.controller.render("Spacer")}
      {this.controller.render("Answer")}        
      </Host>
    )
  }
}
  
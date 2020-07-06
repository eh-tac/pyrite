import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PostMissionQuestions } from "../../../model/TIE";
import { TIEPostMissionQuestionsController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-post-mission-questions",
  styleUrl: "post-mission-questions.scss",
  shadow: false
})
export class TIEPostMissionQuestionsComponent {
  @Element() public el: HTMLElement;
  @Prop() public postmissionquestions: PostMissionQuestions;

  private controller: TIEPostMissionQuestionsController;

  public componentWillLoad(): void {
    this.controller = new TIEPostMissionQuestionsController(this.postmissionquestions);
  }

  public render(): JSX.Element {
    return (
      <Host>
      {this.controller.render("Length")}
      {this.controller.render("QuestionCondition")}
      {this.controller.render("QuestionType")}
      {this.controller.render("Question")}
      {this.controller.render("Spacer")}
      {this.controller.render("Answer")}        
      </Host>
    )
  }
}
  
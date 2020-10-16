import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { PostMissionQuestions } from "../../../model/TIE";
import { TIEPostMissionQuestionsController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-post-mission-questions",
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
        <Field {...this.controller.getProps("Length")} />
        <Field {...this.controller.getProps("QuestionCondition")} />
        <Field {...this.controller.getProps("QuestionType")} />
        <Field {...this.controller.getProps("Question")} />
        <Field {...this.controller.getProps("Spacer")} />
        <Field {...this.controller.getProps("Answer")} />
      </Host>
    );
  }
}

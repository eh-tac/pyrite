import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { PreMissionQuestions } from "../../../model/TIE";
import { TIEPreMissionQuestionsController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-tie-pre-mission-questions",
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
        <Field {...this.controller.getProps('Length')} />
        <Field {...this.controller.getProps('Question')} />
        <Field {...this.controller.getProps('Spacer')} />
        <Field {...this.controller.getProps('Answer')} />
      </Host>
    )
  }
}
  
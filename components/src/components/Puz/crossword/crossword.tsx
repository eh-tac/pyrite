import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Crossword } from "../../../model/Puz";
import { PuzCrosswordController } from "../../../controllers/Puz";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-puz-crossword",
  styleUrl: "crossword.scss",
  shadow: false
})
export class PuzCrosswordComponent {
  @Element() public el: HTMLElement;
  @Prop() public crossword: Crossword;

  private controller: PuzCrosswordController;

  public componentWillLoad(): void {
    this.controller = new PuzCrosswordController(this.crossword);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("FileHeader")} />
        <Field {...this.controller.getProps("SolutionGrid")} />
        <Field {...this.controller.getProps("ProgressGrid")} />
        <Field {...this.controller.getProps("Title")} />
        <Field {...this.controller.getProps("Author")} />
        <Field {...this.controller.getProps("Copyright")} />
        <Field {...this.controller.getProps("Clues")} />
      </Host>
    );
  }
}

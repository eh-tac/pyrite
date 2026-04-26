import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { GoalFG } from "../../../model/TIE";
import { TIEGoalFGController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-goal-fg",
  styleUrl: "goal-fg.scss",
  shadow: false
})
export class TIEGoalFGComponent {
  @Element() public el: HTMLElement;
  @Prop() public goalfg: GoalFG;

  private controller: TIEGoalFGController;

  public componentWillLoad(): void {
    this.controller = new TIEGoalFGController(this.goalfg);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Condition")} />
        <Field {...this.controller.getProps("GoalAmount")} />
      </Host>
    );
  }
}

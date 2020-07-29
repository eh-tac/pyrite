import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { GlobalGoal } from "../../../model/TIE";
import { TIEGlobalGoalController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-global-goal",
  styleUrl: "global-goal.scss",
  shadow: false
})
export class TIEGlobalGoalComponent {
  @Element() public el: HTMLElement;
  @Prop() public globalgoal: GlobalGoal;

  private controller: TIEGlobalGoalController;

  public componentWillLoad(): void {
    this.controller = new TIEGlobalGoalController(this.globalgoal);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Triggers")} />
        <Field {...this.controller.getProps("Trigger1OrTrigger2")} />
      </Host>
    );
  }
}

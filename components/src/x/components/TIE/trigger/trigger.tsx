import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Trigger } from "../../../model/TIE";
import { TIETriggerController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-trigger",
  styleUrl: "trigger.scss",
  shadow: false
})
export class TIETriggerComponent {
  @Element() public el: HTMLElement;
  @Prop() public trigger: Trigger;

  private controller: TIETriggerController;

  public componentWillLoad(): void {
    this.controller = new TIETriggerController(this.trigger);
  }

  public render(): JSX.Element {
    return (
      <Host>
      {this.controller.render("Condition")}
      {this.controller.render("VariableType")}
      {this.controller.render("Variable")}
      {this.controller.render("TriggerAmount")}        
      </Host>
    )
  }
}
  
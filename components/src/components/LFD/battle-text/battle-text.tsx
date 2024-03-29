import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { BattleText } from "../../../model/LFD";
import { LFDBattleTextController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-battle-text",
  styleUrl: "battle-text.scss",
  shadow: false
})
export class LFDBattleTextComponent {
  @Element() public el: HTMLElement;
  @Prop() public battletext: BattleText;

  private controller: LFDBattleTextController;

  public componentWillLoad(): void {
    this.controller = new LFDBattleTextController(this.battletext);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Header")} />
        <Field {...this.controller.getProps("NumStrings")} />
        <Field {...this.controller.getProps("Names")} />
        <Field {...this.controller.getProps("Titles")} />
        <Field {...this.controller.getProps("Image")} />
        <Field {...this.controller.getProps("MissionFiles")} />
        <Field {...this.controller.getProps("MissionDescriptions")} />
      </Host>
    );
  }
}

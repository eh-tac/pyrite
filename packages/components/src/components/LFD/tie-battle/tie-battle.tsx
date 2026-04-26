import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { TIEBattle } from "../../../model/LFD";
import { LFDTIEBattleController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-tie-battle",
  styleUrl: "tie-battle.scss",
  shadow: false
})
export class LFDTIEBattleComponent {
  @Element() public el: HTMLElement;
  @Prop() public tiebattle: TIEBattle;

  private controller: LFDTIEBattleController;

  public componentWillLoad(): void {
    this.controller = new LFDTIEBattleController(this.tiebattle);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('HeaderMap')} />
        <Field {...this.controller.getProps('BattleName')} />
        <Field {...this.controller.getProps('BattleImage')} />
      </Host>
    )
  }
}
  
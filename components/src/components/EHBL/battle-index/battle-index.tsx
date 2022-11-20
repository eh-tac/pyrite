import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { BattleIndex } from "../../../model/EHBL";
import { EHBLBattleIndexController } from "../../../controllers/EHBL";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-ehbl-battle-index",
  styleUrl: "battle-index.scss",
  shadow: false
})
export class EHBLBattleIndexComponent {
  @Element() public el: HTMLElement;
  @Prop() public battleindex: BattleIndex;

  private controller: EHBLBattleIndexController;

  public componentWillLoad(): void {
    this.controller = new EHBLBattleIndexController(this.battleindex);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Platform')} />
        <Field {...this.controller.getProps('EncryptionOffset')} />
        <Field {...this.controller.getProps('Titles')} />
        <Field {...this.controller.getProps('MissionCount')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('MissionFilenames')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('Unknown3')} />
        <Field {...this.controller.getProps('Unknown4')} />
        <Field {...this.controller.getProps('Constant1')} />
        <Field {...this.controller.getProps('Empty1')} />
        <Field {...this.controller.getProps('Unknown5')} />
        <Field {...this.controller.getProps('Unknown6')} />
        <Field {...this.controller.getProps('Constant2')} />
        <Field {...this.controller.getProps('Empty2')} />
        <Field {...this.controller.getProps('BattleNumber')} />
        <Field {...this.controller.getProps('Empty3')} />
      </Host>
    )
  }
}
  
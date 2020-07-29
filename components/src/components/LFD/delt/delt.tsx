import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Delt } from "../../../model/LFD";
import { LFDDeltController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-delt",
  styleUrl: "delt.scss",
  shadow: false
})
export class LFDDeltComponent {
  @Element() public el: HTMLElement;
  @Prop() public delt: Delt;

  private controller: LFDDeltController;

  public componentWillLoad(): void {
    this.controller = new LFDDeltController(this.delt);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Left')} />
        <Field {...this.controller.getProps('Top')} />
        <Field {...this.controller.getProps('Right')} />
        <Field {...this.controller.getProps('Bottom')} />
        <Field {...this.controller.getProps('Rows')} />
        <Field {...this.controller.getProps('Reserved')} />
      </Host>
    )
  }
}
  
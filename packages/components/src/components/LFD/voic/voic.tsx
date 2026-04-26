import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Voic } from "../../../model/LFD";
import { LFDVoicController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-voic",
  styleUrl: "voic.scss",
  shadow: false
})
export class LFDVoicComponent {
  @Element() public el: HTMLElement;
  @Prop() public voic: Voic;

  private controller: LFDVoicController;

  public componentWillLoad(): void {
    this.controller = new LFDVoicController(this.voic);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Header')} />
        <Field {...this.controller.getProps('Data')} />
      </Host>
    )
  }
}
  
import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { VoicData } from "../../../model/LFD";
import { LFDVoicDataController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-voic-data",
  styleUrl: "voic-data.scss",
  shadow: false
})
export class LFDVoicDataComponent {
  @Element() public el: HTMLElement;
  @Prop() public voicdata: VoicData;

  private controller: LFDVoicDataController;

  public componentWillLoad(): void {
    this.controller = new LFDVoicDataController(this.voicdata);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Type')} />
        <Field {...this.controller.getProps('Size')} />
        <Field {...this.controller.getProps('Data')} />
      </Host>
    )
  }
}
  
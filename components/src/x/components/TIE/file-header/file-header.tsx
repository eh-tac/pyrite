import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { FileHeader } from "../../../model/TIE";
import { TIEFileHeaderController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-tie-file-header",
  styleUrl: "file-header.scss",
  shadow: false
})
export class TIEFileHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public fileheader: FileHeader;

  private controller: TIEFileHeaderController;

  public componentWillLoad(): void {
    this.controller = new TIEFileHeaderController(this.fileheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('PlatformID')} />
        <Field {...this.controller.getProps('NumFGs')} />
        <Field {...this.controller.getProps('NumMessages')} />
        <Field {...this.controller.getProps('NumGGs')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('BriefingOfficers')} />
        <Field {...this.controller.getProps('CapturedOnEject')} />
        <Field {...this.controller.getProps('EndOfMissionMessages')} />
        <Field {...this.controller.getProps('OtherIffNames')} />
      </Host>
    )
  }
}
  
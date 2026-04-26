import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { FileHeader } from "../../../model/XWA";
import { XWAFileHeaderController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-file-header",
  styleUrl: "file-header.scss",
  shadow: false
})
export class XWAFileHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public fileheader: FileHeader;

  private controller: XWAFileHeaderController;

  public componentWillLoad(): void {
    this.controller = new XWAFileHeaderController(this.fileheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('PlatformID')} />
        <Field {...this.controller.getProps('NumFGs')} />
        <Field {...this.controller.getProps('NumMessages')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('IffNames3-6')} />
        <Field {...this.controller.getProps('RegionNames')} />
        <Field {...this.controller.getProps('Unnamed')} />
        <Field {...this.controller.getProps('GlobalGroupNames')} />
        <Field {...this.controller.getProps('Hangar')} />
        <Field {...this.controller.getProps('TimeLimitMinutes')} />
        <Field {...this.controller.getProps('EndMissionWhenComplete')} />
        <Field {...this.controller.getProps('BriefingOfficer')} />
        <Field {...this.controller.getProps('BriefingLogo')} />
        <Field {...this.controller.getProps('Unknown3')} />
        <Field {...this.controller.getProps('Unknown4')} />
        <Field {...this.controller.getProps('Unknown5')} />
      </Host>
    )
  }
}
  
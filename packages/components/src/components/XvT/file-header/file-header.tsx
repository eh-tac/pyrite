import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { FileHeader } from "../../../model/XvT";
import { XvTFileHeaderController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-file-header",
  styleUrl: "file-header.scss",
  shadow: false
})
export class XvTFileHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public fileheader: FileHeader;

  private controller: XvTFileHeaderController;

  public componentWillLoad(): void {
    this.controller = new XvTFileHeaderController(this.fileheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('PlatformID')} />
        <Field {...this.controller.getProps('NumFGs')} />
        <Field {...this.controller.getProps('NumMessages')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('Unknown3')} />
        <Field {...this.controller.getProps('Unknown4')} />
        <Field {...this.controller.getProps('Unknown5')} />
        <Field {...this.controller.getProps('MissionType')} />
        <Field {...this.controller.getProps('Unknown6')} />
        <Field {...this.controller.getProps('TimeLimitMinutes')} />
        <Field {...this.controller.getProps('TimeLimitSeconds')} />
      </Host>
    )
  }
}
  
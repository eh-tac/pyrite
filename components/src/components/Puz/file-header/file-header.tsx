import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { FileHeader } from "../../../model/Puz";
import { PuzFileHeaderController } from "../../../controllers/Puz";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-puz-file-header",
  styleUrl: "file-header.scss",
  shadow: false
})
export class PuzFileHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public fileheader: FileHeader;

  private controller: PuzFileHeaderController;

  public componentWillLoad(): void {
    this.controller = new PuzFileHeaderController(this.fileheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("FileChecksum")} />
        <Field {...this.controller.getProps("Descriptor")} />
        <Field {...this.controller.getProps("BaseChecksum")} />
        <Field {...this.controller.getProps("MaskedChecksums")} />
        <Field {...this.controller.getProps("Version")} />
        <Field {...this.controller.getProps("Unused")} />
        <Field {...this.controller.getProps("Unknown")} />
        <Field {...this.controller.getProps("Reserved")} />
        <Field {...this.controller.getProps("Width")} />
        <Field {...this.controller.getProps("Height")} />
        <Field {...this.controller.getProps("NumClues")} />
        <Field {...this.controller.getProps("Bitmask1")} />
        <Field {...this.controller.getProps("Bitmask2")} />
      </Host>
    );
  }
}

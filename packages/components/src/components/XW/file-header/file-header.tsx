import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { FileHeader } from "../../../model/XW";
import { XWFileHeaderController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-file-header",
  styleUrl: "file-header.scss",
  shadow: false
})
export class XWFileHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public fileheader: FileHeader;

  private controller: XWFileHeaderController;

  public componentWillLoad(): void {
    this.controller = new XWFileHeaderController(this.fileheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Version")} />
        <Field {...this.controller.getProps("TimeLimit")} />
        <Field {...this.controller.getProps("EndState")} />
        <Field {...this.controller.getProps("Reserved")} />
        <Field {...this.controller.getProps("MissionLocation")} />
        <Field {...this.controller.getProps("CompletionMessage")} />
        <Field {...this.controller.getProps("NumFGs")} />
        <Field {...this.controller.getProps("NumObj")} />
      </Host>
    );
  }
}

import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { BriefingHeader } from "../../../model/XW";
import { XWBriefingHeaderController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-briefing-header",
  styleUrl: "briefing-header.scss",
  shadow: false
})
export class XWBriefingHeaderComponent {
  @Element() public el: HTMLElement;
  @Prop() public briefingheader: BriefingHeader;

  private controller: XWBriefingHeaderController;

  public componentWillLoad(): void {
    this.controller = new XWBriefingHeaderController(this.briefingheader);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('PlatformID')} />
        <Field {...this.controller.getProps('IconCount')} />
        <Field {...this.controller.getProps('CoordinateCount')} />
      </Host>
    )
  }
}
  
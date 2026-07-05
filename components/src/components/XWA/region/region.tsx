import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Region } from "../../../../old-assets/model/XWA";
import { XWARegionController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-region",
  styleUrl: "region.scss",
  shadow: false,
})
export class XWARegionComponent {
  @Element() public el: HTMLElement;
  @Prop() public region: Region;

  private controller: XWARegionController;

  public componentWillLoad(): void {
    this.controller = new XWARegionController(this.region);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Name")} />
        <Field {...this.controller.getProps("ID")} />
      </Host>
    );
  }
}

import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Page } from "../../../model/XW";
import { XWPageController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-page",
  styleUrl: "page.scss",
  shadow: false
})
export class XWPageComponent {
  @Element() public el: HTMLElement;
  @Prop() public page: Page;

  private controller: XWPageController;

  public componentWillLoad(): void {
    this.controller = new XWPageController(this.page);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Duration')} />
        <Field {...this.controller.getProps('EventsLength')} />
        <Field {...this.controller.getProps('CoordinateSet')} />
        <Field {...this.controller.getProps('PageType')} />
        <Field {...this.controller.getProps('Events[EventsLength]')} />
      </Host>
    )
  }
}
  
import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Event } from "../../../model/XWA";
import { XWAEventController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-event",
  styleUrl: "event.scss",
  shadow: false
})
export class XWAEventComponent {
  @Element() public el: HTMLElement;
  @Prop() public event: Event;

  private controller: XWAEventController;

  public componentWillLoad(): void {
    this.controller = new XWAEventController(this.event);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Time')} />
        <Field {...this.controller.getProps('Type')} />
        <Field {...this.controller.getProps('Variables')} />
      </Host>
    )
  }
}
  
import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Event } from "../../../model/XvT";
import { XvTEventController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-event",
  styleUrl: "event.scss",
  shadow: false
})
export class XvTEventComponent {
  @Element() public el: HTMLElement;
  @Prop() public event: Event;

  private controller: XvTEventController;

  public componentWillLoad(): void {
    this.controller = new XvTEventController(this.event);
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
  
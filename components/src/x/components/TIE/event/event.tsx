import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Event } from "../../../model/TIE";
import { TIEEventController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-tie-event",
  styleUrl: "event.scss",
  shadow: false
})
export class TIEEventComponent {
  @Element() public el: HTMLElement;
  @Prop() public event: Event;

  private controller: TIEEventController;

  public componentWillLoad(): void {
    this.controller = new TIEEventController(this.event);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Time')} />
        <Field {...this.controller.getProps('EventType')} />
        <Field {...this.controller.getProps('Variables')} />
      </Host>
    )
  }
}
  
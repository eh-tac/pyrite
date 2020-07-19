import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Message } from "../../../model/TIE";
import { TIEMessageController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "xpyrite-tie-message",
  styleUrl: "message.scss",
  shadow: false
})
export class TIEMessageComponent {
  @Element() public el: HTMLElement;
  @Prop() public message: Message;

  private controller: TIEMessageController;

  public componentWillLoad(): void {
    this.controller = new TIEMessageController(this.message);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Message')} />
        <Field {...this.controller.getProps('Triggers')} />
        <Field {...this.controller.getProps('EditorNote')} />
        <Field {...this.controller.getProps('DelaySeconds')} />
        <Field {...this.controller.getProps('Trigger1OrTrigger2')} />
      </Host>
    )
  }
}
  
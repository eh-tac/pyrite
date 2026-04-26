import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Message } from "../../../model/XvT";
import { XvTMessageController } from "../../../controllers/XvT";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xvt-message",
  styleUrl: "message.scss",
  shadow: false
})
export class XvTMessageComponent {
  @Element() public el: HTMLElement;
  @Prop() public message: Message;

  private controller: XvTMessageController;

  public componentWillLoad(): void {
    this.controller = new XvTMessageController(this.message);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('MessageIndex')} />
        <Field {...this.controller.getProps('Message')} />
        <Field {...this.controller.getProps('SentToTeams')} />
        <Field {...this.controller.getProps('TriggerA')} />
        <Field {...this.controller.getProps('Trigger1OrTrigger2')} />
        <Field {...this.controller.getProps('TriggerB')} />
        <Field {...this.controller.getProps('Trigger3OrTrigger4')} />
        <Field {...this.controller.getProps('EditorNote')} />
        <Field {...this.controller.getProps('DelaySeconds')} />
        <Field {...this.controller.getProps('Trigger12OrTrigger34')} />
      </Host>
    )
  }
}
  
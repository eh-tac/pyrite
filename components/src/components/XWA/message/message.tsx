import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Message } from "../../../model/XWA";
import { XWAMessageController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-message",
  styleUrl: "message.scss",
  shadow: false
})
export class XWAMessageComponent {
  @Element() public el: HTMLElement;
  @Prop() public message: Message;

  private controller: XWAMessageController;

  public componentWillLoad(): void {
    this.controller = new XWAMessageController(this.message);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('MessageIndex')} />
        <Field {...this.controller.getProps('Message')} />
        <Field {...this.controller.getProps('SetToTeam')} />
        <Field {...this.controller.getProps('Trigger1')} />
        <Field {...this.controller.getProps('Trigger2')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('Trigger1OrTrigger2')} />
        <Field {...this.controller.getProps('Trigger3')} />
        <Field {...this.controller.getProps('Trigger4')} />
        <Field {...this.controller.getProps('Trigger3OrTrigger4')} />
        <Field {...this.controller.getProps('Voice')} />
        <Field {...this.controller.getProps('OriginatingFG')} />
        <Field {...this.controller.getProps('DelaySeconds')} />
        <Field {...this.controller.getProps('Triggers12OrTriggers34')} />
        <Field {...this.controller.getProps('Color')} />
        <Field {...this.controller.getProps('Unknown2')} />
        <Field {...this.controller.getProps('Cancel1')} />
        <Field {...this.controller.getProps('Cancel2')} />
        <Field {...this.controller.getProps('Cancel1OrCancel2')} />
        <Field {...this.controller.getProps('Unknown3')} />
      </Host>
    )
  }
}
  
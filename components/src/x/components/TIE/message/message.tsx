import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Message } from "../../../model/TIE";
import { TIEMessageController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-message",
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
      {this.controller.render("Message")}
      {this.controller.render("Triggers")}
      {this.controller.render("EditorNote")}
      {this.controller.render("DelaySeconds")}
      {this.controller.render("Trigger1OrTrigger2")}        
      </Host>
    )
  }
}
  
import { Component, h, JSX, Prop, State } from "@stencil/core";
import { Message } from "../../../model/TIE";
import { Mission } from "../../../model/TIE/mission";

@Component({
  tag: "pyrite-tie-messages",
  styleUrl: "messages.scss",
  shadow: false
})
export class TIEMessagesComponent {
  @Prop() public mission: Mission;
  @State() public messages: Message[];
  @State() public selectedMSG: Message;

  public componentWillLoad() {
    this.messages = this.mission.Messages;
    this.selectedMSG = this.messages[0];
  }

  protected selectMSG(msg: Message): void {
    this.selectedMSG = msg;
  }

  public renderMSGMenu(msg: Message): JSX.Element {
    return (
      <li class={`color-${msg.MessageColourLabel}`}>
        <a onClick={this.selectMSG.bind(this, msg)} class="button py-1 is-size-7 has-text-left">
          {msg.DisplayText}
        </a>
      </li>
    );
  }

  public render() {
    return (
      <div class="columns">
        <div class="menu column is-one-third">
          <ul class="menu-list">{this.messages.map(this.renderMSGMenu.bind(this))}</ul>
        </div>
        <div class="column">
          <pyrite-tie-message message={this.selectedMSG} />
        </div>
      </div>
    );
  }
}

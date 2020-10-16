import { Component, h, JSX, Prop, State } from "@stencil/core";
import { Message } from "../../../model/TIE";

@Component({
  tag: "pyrite-tie-message",
  styleUrl: "message.scss",
  shadow: false
})
export class TIEMessageComponent {
  @Prop() public message: Message;

  public componentWillLoad() {}

  public render() {
    return <p>{this.message.DisplayText}</p>;
  }
}

import { Component, Prop, State, h, Host, JSX, Element } from "@stencil/core";
import { Mission } from "../../model/TIE";

@Component({
  tag: "pyrite-mission-wrapper",
  styleUrl: "",
  shadow: true
})
export class PyriteMissionWrapper {
  @Element() public el: HTMLElement;
  @Prop() public file: string;

  @State() protected tie: Mission;
  @State() protected selectedTab: string;

  public componentWillLoad(): void {
    if (!this.file) {
      return;
    }
    fetch(this.file)
      .then((res: Response) => res.arrayBuffer())
      .then((value: ArrayBuffer) => {
        this.tie = new Mission(value);
        const slot = this.el.shadowRoot.firstChild as HTMLSlotElement;
        const child = slot.assignedElements()[0];
        child["mission"] = this.tie;
      });
  }

  public render(): JSX.Element {
    return (
      <Host>
        <slot />
      </Host>
    );
  }
}

import { Component, Prop, State, h, Host, JSX, Element } from "@stencil/core";
import { getByte } from "../../hex";
import { Mission as TIEMission } from "../../model/TIE";
import { Mission as XWMission } from "../../model/XW";
import { Mission as XvTMission } from "../../model/XvT";
import { Mission as XWAMission } from "../../model/XWA";

@Component({
  tag: "pyrite-mission-wrapper",
  styleUrl: "",
  shadow: true
})
export class PyriteMissionWrapper {
  @Element() public el: HTMLElement;
  @Prop() public file: string;

  @State() protected tie: XWMission | TIEMission | XvTMission | XWAMission;

  public componentWillLoad(): void {
    if (!this.file) {
      return;
    }
    fetch(this.file)
      .then((res: Response) => res.arrayBuffer())
      .then((value: ArrayBuffer) => {
        const first = getByte(value, 0);
        if (first === 2) {
          this.tie = new XWMission(value);
        } else if (first === 255) {
          this.tie = new TIEMission(value);
        } else if (first === 12 || first === 14) {
          this.tie = new XvTMission(value);
        } else if (first === 18) {
          this.tie = new XWAMission(value);
        } else {
          console.warn("no idea how to parse this one", first, value);
        }
        if (this.tie) {
          console.log("loaded mission", this.file, this.tie);
          const slot = this.el.shadowRoot.firstChild as HTMLSlotElement;
          const child = slot.assignedElements()[0];
          if (child) {
            child["mission"] = this.tie;
          }
        }
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

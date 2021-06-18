import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Rmap, BattleText, Delt } from "../../../model/LFD";
import { LFDRmapController } from "../../../controllers/LFD";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-lfd-rmap",
  styleUrl: "rmap.scss",
  shadow: false
})
export class LFDRmapComponent {
  @Element() public el: HTMLElement;
  @Prop() public rmap: Rmap;

  private controller: LFDRmapController;

  public componentWillLoad(): void {
    this.controller = new LFDRmapController(this.rmap);
  }

  public render(): JSX.Element {
    console.log("lfd rmap comp", this.rmap);
    return (
      <Host>
        <Field {...this.controller.getProps("Header")} />
        {this.rmap.Subheaders.map(s => (
          <Field {...this.controller.getProps("Subheaders", s)} />
        ))}
        {this.rmap.RawData.map((r, i) => {
          if (r instanceof BattleText) {
            return <pyrite-lfd-battle-text battletext={r}></pyrite-lfd-battle-text>;
          } else if (r instanceof Delt) {
            return <h3>Delt</h3>;
          }
          return "";
        })}
      </Host>
    );
  }
}

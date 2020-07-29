import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Rmap } from "../../../model/LFD";
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
        {this.rmap.RawData.map((r, i) => [
          <p>Rmap Raw Data {i}</p>,
          <pyrite-lfd-header header={r.Header}></pyrite-lfd-header>
        ])}
      </Host>
    );
  }
}

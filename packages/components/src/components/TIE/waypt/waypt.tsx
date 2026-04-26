import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { Waypt } from "../../../model/TIE";
import { TIEWayptController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-waypt",
  styleUrl: "waypt.scss",
  shadow: false
})
export class TIEWayptComponent {
  @Element() public el: HTMLElement;
  @Prop() public waypt: Waypt;

  private controller: TIEWayptController;

  public componentWillLoad(): void {
    this.controller = new TIEWayptController(this.waypt);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("StartPoints")} />
        <Field {...this.controller.getProps("Waypoints")} />
        <Field {...this.controller.getProps("Rendezvous")} />
        <Field {...this.controller.getProps("Hyperspace")} />
        <Field {...this.controller.getProps("Briefing")} />
      </Host>
    );
  }
}

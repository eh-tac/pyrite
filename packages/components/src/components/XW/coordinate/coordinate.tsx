import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { Coordinate } from "../../../model/XW";
import { XWCoordinateController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-coordinate",
  styleUrl: "coordinate.scss",
  shadow: false
})
export class XWCoordinateComponent {
  @Element() public el: HTMLElement;
  @Prop() public coordinate: Coordinate;

  private controller: XWCoordinateController;

  public componentWillLoad(): void {
    this.controller = new XWCoordinateController(this.coordinate);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('X')} />
        <Field {...this.controller.getProps('Y')} />
        <Field {...this.controller.getProps('Z')} />
      </Host>
    )
  }
}
  
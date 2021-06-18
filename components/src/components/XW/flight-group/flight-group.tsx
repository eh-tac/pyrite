import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { FlightGroup } from "../../../model/XW";
import { XWFlightGroupController } from "../../../controllers/XW";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xw-flight-group",
  styleUrl: "flight-group.scss",
  shadow: false
})
export class XWFlightGroupComponent {
  @Element() public el: HTMLElement;
  @Prop() public flightgroup: FlightGroup;

  private controller: XWFlightGroupController;

  public componentWillLoad(): void {
    this.controller = new XWFlightGroupController(this.flightgroup);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Name")} />
        <Field {...this.controller.getProps("Cargo")} />
        <Field {...this.controller.getProps("SpecialCargo")} />
        <Field {...this.controller.getProps("SpecialCargoCraft")} />
        <Field {...this.controller.getProps("CraftType")} />
        <Field {...this.controller.getProps("IFF")} />
        <Field {...this.controller.getProps("FlightGroupStatus")} />
        <Field {...this.controller.getProps("NumberOfCraft")} />
        <Field {...this.controller.getProps("NumberOfWaves")} />
        <Field {...this.controller.getProps("ArrivalEvent")} />
        <Field {...this.controller.getProps("ArrivalDelay")} />
        <Field {...this.controller.getProps("ArrivalFlightGroup")} />
        <Field {...this.controller.getProps("MothershipFlightGroup")} />
        <Field {...this.controller.getProps("ArriveByHyperspace")} />
        <Field {...this.controller.getProps("DepartByHyperspace")} />
        <Field {...this.controller.getProps("XCoordinates")} />
        <Field {...this.controller.getProps("YCoordinates")} />
        <Field {...this.controller.getProps("ZCoordinates")} />
        <Field {...this.controller.getProps("CoordinatesEnabled")} />
        <Field {...this.controller.getProps("Formation")} />
        <Field {...this.controller.getProps("PlayerCraft")} />
        <Field {...this.controller.getProps("CraftAI")} />
        <Field {...this.controller.getProps("Order")} />
        <Field {...this.controller.getProps("OrderVariable")} />
        <Field {...this.controller.getProps("CraftColour")} />
        <Field {...this.controller.getProps("Reserved")} />
        <Field {...this.controller.getProps("CraftObjective")} />
        <Field {...this.controller.getProps("PrimaryTarget")} />
        <Field {...this.controller.getProps("SecondaryTarget")} />
      </Host>
    );
  }
}

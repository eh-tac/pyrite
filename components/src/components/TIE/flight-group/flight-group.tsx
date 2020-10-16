import { Component, Prop, Host, h, JSX, Element } from "@stencil/core";
import { FlightGroup } from "../../../model/TIE";
import { TIEFlightGroupController } from "../../../controllers/TIE";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-tie-flight-group",
  styleUrl: "flight-group.scss",
  shadow: false
})
export class TIEFlightGroupComponent {
  @Element() public el: HTMLElement;
  @Prop() public flightgroup: FlightGroup;

  private controller: TIEFlightGroupController;

  public componentWillLoad(): void {
    this.controller = new TIEFlightGroupController(this.flightgroup);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps("Name")} />
        <Field {...this.controller.getProps("Pilot")} />
        <Field {...this.controller.getProps("Cargo")} />
        <Field {...this.controller.getProps("SpecialCargo")} />
        <Field {...this.controller.getProps("SpecialCargoCraft")} />
        <Field {...this.controller.getProps("RandomSpecialCargoCraft")} />
        <Field {...this.controller.getProps("CraftType")} />
        <Field {...this.controller.getProps("NumberOfCraft")} />
        <Field {...this.controller.getProps("Status")} />
        <Field {...this.controller.getProps("Warhead")} />
        <Field {...this.controller.getProps("Beam")} />
        <Field {...this.controller.getProps("Iff")} />
        <Field {...this.controller.getProps("GroupAI")} />
        <Field {...this.controller.getProps("Markings")} />
        <Field {...this.controller.getProps("ObeyPlayerOrders")} />
        <Field {...this.controller.getProps("Reserved1")} />
        <Field {...this.controller.getProps("Formation")} />
        <Field {...this.controller.getProps("FormationSpacing")} />
        <Field {...this.controller.getProps("GlobalGroup")} />
        <Field {...this.controller.getProps("LeaderSpacing")} />
        <Field {...this.controller.getProps("NumberOfWaves")} />
        <Field {...this.controller.getProps("Unknown5")} />
        <Field {...this.controller.getProps("PlayerCraft")} />
        <Field {...this.controller.getProps("Yaw")} />
        <Field {...this.controller.getProps("Pitch")} />
        <Field {...this.controller.getProps("Roll")} />
        <Field {...this.controller.getProps("Unknown9")} />
        <Field {...this.controller.getProps("Unknown10")} />
        <Field {...this.controller.getProps("Reserved2")} />
        <Field {...this.controller.getProps("ArrivalDifficulty")} />
        <Field {...this.controller.getProps("Arrival1")} />
        <Field {...this.controller.getProps("Arrival2")} />
        <Field {...this.controller.getProps("Arrival1OrArrival2")} />
        <Field {...this.controller.getProps("Reserved3")} />
        <Field {...this.controller.getProps("ArrivalDelayMinutes")} />
        <Field {...this.controller.getProps("ArrivalDelaySeconds")} />
        <Field {...this.controller.getProps("Departure")} />
        <Field {...this.controller.getProps("DepartureDelayMinutes")} />
        <Field {...this.controller.getProps("DepartureDelatSeconds")} />
        <Field {...this.controller.getProps("AbortTrigger")} />
        <Field {...this.controller.getProps("Reserved4")} />
        <Field {...this.controller.getProps("Unknown16")} />
        <Field {...this.controller.getProps("Reserved5")} />
        <Field {...this.controller.getProps("ArrivalMothership")} />
        <Field {...this.controller.getProps("ArriveViaMothership")} />
        <Field {...this.controller.getProps("DepartureMothership")} />
        <Field {...this.controller.getProps("DepartViaMothership")} />
        <Field {...this.controller.getProps("AlternateArrivalMothership")} />
        <Field {...this.controller.getProps("AlternateArriveViaMothership")} />
        <Field {...this.controller.getProps("AlternateDepartureMothership")} />
        <Field {...this.controller.getProps("AlternateDepartViaMothership")} />
        <Field {...this.controller.getProps("Orders")} />
        <Field {...this.controller.getProps("FlightGroupGoals")} />
        <Field {...this.controller.getProps("BonusGoalPoints")} />
        <Field {...this.controller.getProps("Waypoints")} />
        <Field {...this.controller.getProps("Unknown19")} />
        <Field {...this.controller.getProps("Unknown20")} />
        <Field {...this.controller.getProps("Unknown21")} />
      </Host>
    );
  }
}

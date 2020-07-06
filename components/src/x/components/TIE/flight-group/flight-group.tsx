import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { FlightGroup } from "../../../model/TIE";
import { TIEFlightGroupController } from "../../../controllers/TIE";

@Component({
  tag: "pyrite-TIE-flight-group",
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
      {this.controller.render("Name")}
      {this.controller.render("Pilot")}
      {this.controller.render("Cargo")}
      {this.controller.render("SpecialCargo")}
      {this.controller.render("SpecialCargoCraft")}
      {this.controller.render("RandomSpecialCargoCraft")}
      {this.controller.render("CraftType")}
      {this.controller.render("NumberOfCraft")}
      {this.controller.render("Status")}
      {this.controller.render("Warhead")}
      {this.controller.render("Beam")}
      {this.controller.render("Iff")}
      {this.controller.render("GroupAI")}
      {this.controller.render("Markings")}
      {this.controller.render("ObeyPlayerOrders")}
      {this.controller.render("Reserved1")}
      {this.controller.render("Formation")}
      {this.controller.render("FormationSpacing")}
      {this.controller.render("GlobalGroup")}
      {this.controller.render("LeaderSpacing")}
      {this.controller.render("NumberOfWaves")}
      {this.controller.render("Unknown5")}
      {this.controller.render("PlayerCraft")}
      {this.controller.render("Yaw")}
      {this.controller.render("Pitch")}
      {this.controller.render("Roll")}
      {this.controller.render("Unknown9")}
      {this.controller.render("Unknown10")}
      {this.controller.render("Reserved2")}
      {this.controller.render("ArrivalDifficulty")}
      {this.controller.render("Arrival1")}
      {this.controller.render("Arrival2")}
      {this.controller.render("Arrival1OrArrival2")}
      {this.controller.render("Reserved3")}
      {this.controller.render("ArrivalDelayMinutes")}
      {this.controller.render("ArrivalDelaySeconds")}
      {this.controller.render("Departure")}
      {this.controller.render("DepartureDelayMinutes")}
      {this.controller.render("DepartureDelatSeconds")}
      {this.controller.render("AbortTrigger")}
      {this.controller.render("Reserved4")}
      {this.controller.render("Unknown16")}
      {this.controller.render("Reserved5")}
      {this.controller.render("ArrivalMothership")}
      {this.controller.render("ArriveViaMothership")}
      {this.controller.render("DepartureMothership")}
      {this.controller.render("DepartViaMothership")}
      {this.controller.render("AlternateArrivalMothership")}
      {this.controller.render("AlternateArriveViaMothership")}
      {this.controller.render("AlternateDepartureMothership")}
      {this.controller.render("AlternateDepartViaMothership")}
      {this.controller.render("Orders")}
      {this.controller.render("FlightGroupGoals")}
      {this.controller.render("BonusGoalPoints")}
      {this.controller.render("Waypoints")}
      {this.controller.render("Unknown19")}
      {this.controller.render("Unknown20")}
      {this.controller.render("Unknown21")}        
      </Host>
    )
  }
}
  
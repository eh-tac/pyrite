import { Component, Prop, Host, h, JSX, Element } from "@stencil/core"
import { FlightGroup } from "../../../model/XWA";
import { XWAFlightGroupController } from "../../../controllers/XWA";
import { Field } from "../../fields/field";

@Component({
  tag: "pyrite-xwa-flight-group",
  styleUrl: "flight-group.scss",
  shadow: false
})
export class XWAFlightGroupComponent {
  @Element() public el: HTMLElement;
  @Prop() public flightgroup: FlightGroup;

  private controller: XWAFlightGroupController;

  public componentWillLoad(): void {
    this.controller = new XWAFlightGroupController(this.flightgroup);
  }

  public render(): JSX.Element {
    return (
      <Host>
        <Field {...this.controller.getProps('Name')} />
        <Field {...this.controller.getProps('EnableDesignation')} />
        <Field {...this.controller.getProps('EnableDesignation2')} />
        <Field {...this.controller.getProps('Designation1')} />
        <Field {...this.controller.getProps('Designation2')} />
        <Field {...this.controller.getProps('Unknown1')} />
        <Field {...this.controller.getProps('GlobalCargoIndex')} />
        <Field {...this.controller.getProps('GlobalSpecialCargoIndex')} />
        <Field {...this.controller.getProps('Cargo')} />
        <Field {...this.controller.getProps('SpecialCargo')} />
        <Field {...this.controller.getProps('CraftRole')} />
        <Field {...this.controller.getProps('SpecialCargoCraft')} />
        <Field {...this.controller.getProps('RandomSpecialCargoCraft')} />
        <Field {...this.controller.getProps('CraftType')} />
        <Field {...this.controller.getProps('NumberOfCraft')} />
        <Field {...this.controller.getProps('Status1')} />
        <Field {...this.controller.getProps('Warhead')} />
        <Field {...this.controller.getProps('Beam')} />
        <Field {...this.controller.getProps('Iff')} />
        <Field {...this.controller.getProps('Team')} />
        <Field {...this.controller.getProps('GroupAI')} />
        <Field {...this.controller.getProps('Markings')} />
        <Field {...this.controller.getProps('Radio')} />
        <Field {...this.controller.getProps('Formation')} />
        <Field {...this.controller.getProps('FormationSpacing')} />
        <Field {...this.controller.getProps('GlobalGroup')} />
        <Field {...this.controller.getProps('LeaderSpacing')} />
        <Field {...this.controller.getProps('NumberOfWaves')} />
        <Field {...this.controller.getProps('Unknown3')} />
        <Field {...this.controller.getProps('PlayerNumber')} />
        <Field {...this.controller.getProps('ArriveOnlyIfHuman')} />
        <Field {...this.controller.getProps('PlayerCraft')} />
        <Field {...this.controller.getProps('Yaw')} />
        <Field {...this.controller.getProps('Pitch')} />
        <Field {...this.controller.getProps('Roll')} />
        <Field {...this.controller.getProps('Unknown4')} />
        <Field {...this.controller.getProps('Unknown5')} />
        <Field {...this.controller.getProps('ArrivalDifficulty')} />
        <Field {...this.controller.getProps('Arrival1')} />
        <Field {...this.controller.getProps('Arrival2')} />
        <Field {...this.controller.getProps('Arrival1OrArrival2')} />
        <Field {...this.controller.getProps('Unknown6')} />
        <Field {...this.controller.getProps('Arrival3')} />
        <Field {...this.controller.getProps('Arrival4')} />
        <Field {...this.controller.getProps('Arrival3OrArrival4')} />
        <Field {...this.controller.getProps('Arrivals12OrArrivals34')} />
        <Field {...this.controller.getProps('ArrivalDelayMinutes')} />
        <Field {...this.controller.getProps('ArrivalDelaySeconds')} />
        <Field {...this.controller.getProps('Departure1')} />
        <Field {...this.controller.getProps('Departure2')} />
        <Field {...this.controller.getProps('Departure1OrDeparture2')} />
        <Field {...this.controller.getProps('DepartureDelayMinutes')} />
        <Field {...this.controller.getProps('DepartureDelaySeconds')} />
        <Field {...this.controller.getProps('AbortTrigger')} />
        <Field {...this.controller.getProps('Unknown7')} />
        <Field {...this.controller.getProps('Unknown8')} />
        <Field {...this.controller.getProps('ArrivalMothership')} />
        <Field {...this.controller.getProps('ArriveViaMothership')} />
        <Field {...this.controller.getProps('DepartureMothership')} />
        <Field {...this.controller.getProps('DepartViaMothership')} />
        <Field {...this.controller.getProps('AlternateArrivalMothership')} />
        <Field {...this.controller.getProps('AlternateArriveViaMothership')} />
        <Field {...this.controller.getProps('AlternateDepartureMothership')} />
        <Field {...this.controller.getProps('AlternateDepartViaMothership')} />
        <Field {...this.controller.getProps('Unnamed')} />
        <Field {...this.controller.getProps('StartPoints')} />
        <Field {...this.controller.getProps('HyperPoint')} />
        <Field {...this.controller.getProps('StartPointRegions')} />
        <Field {...this.controller.getProps('HyperPointRegion')} />
        <Field {...this.controller.getProps('Unknown16')} />
        <Field {...this.controller.getProps('Unknown17')} />
        <Field {...this.controller.getProps('Unknown18')} />
        <Field {...this.controller.getProps('Unknown19')} />
        <Field {...this.controller.getProps('Unknown20')} />
        <Field {...this.controller.getProps('Unknown21')} />
        <Field {...this.controller.getProps('Unknown22')} />
        <Field {...this.controller.getProps('Unknown23')} />
        <Field {...this.controller.getProps('Unknown24')} />
        <Field {...this.controller.getProps('Unknown25')} />
        <Field {...this.controller.getProps('Unknown26')} />
        <Field {...this.controller.getProps('Unknown27')} />
        <Field {...this.controller.getProps('Unknown28')} />
        <Field {...this.controller.getProps('Unknown29')} />
        <Field {...this.controller.getProps('Unknown30')} />
        <Field {...this.controller.getProps('Unknown31')} />
        <Field {...this.controller.getProps('EnableGlobalUnit')} />
        <Field {...this.controller.getProps('Unknown32')} />
        <Field {...this.controller.getProps('Unknown33')} />
        <Field {...this.controller.getProps('Countermeasures')} />
        <Field {...this.controller.getProps('CraftExplosionTime')} />
        <Field {...this.controller.getProps('Status2')} />
        <Field {...this.controller.getProps('GlobalUnit')} />
        <Field {...this.controller.getProps('OptionalWarheads')} />
        <Field {...this.controller.getProps('OptionalBeams')} />
        <Field {...this.controller.getProps('OptionalCountermeasures')} />
        <Field {...this.controller.getProps('OptionalCraftCategory')} />
        <Field {...this.controller.getProps('OptionalCraft')} />
        <Field {...this.controller.getProps('NumberOfOptionalCraft')} />
        <Field {...this.controller.getProps('NumberofOptionalCraftWaves')} />
        <Field {...this.controller.getProps('PilotID')} />
        <Field {...this.controller.getProps('Backdrop')} />
        <Field {...this.controller.getProps('Unknown34')} />
        <Field {...this.controller.getProps('Unknown35')} />
        <Field {...this.controller.getProps('Unknown36')} />
        <Field {...this.controller.getProps('Unknown37')} />
        <Field {...this.controller.getProps('Unknown38')} />
        <Field {...this.controller.getProps('Unknown39')} />
        <Field {...this.controller.getProps('Unknown40')} />
        <Field {...this.controller.getProps('Unknown41')} />
      </Host>
    )
  }
}
  
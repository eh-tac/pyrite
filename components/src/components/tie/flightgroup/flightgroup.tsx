import { Component, h, JSX, Prop, State, Listen } from "@stencil/core";
import { FlightGroup, GoalFG, Order, Waypt } from "../../../model/TIE";
import { Field } from "../../fields/field";

enum Tab {
  INFO = "info",
  ARR = "arrival",
  GOALS = "goals",
  WAY = "waypoints",
  ORDERS = "orders",
  OPT = "options",
  UNK = "unknown"
}

const tabs: { [K in Tab]: string } = {
  info: "Info",
  arrival: "Arrival/Departure",
  goals: "Goals",
  orders: "Orders",
  waypoints: "Waypoints",
  options: "Options",
  unknown: "Unknown"
};

@Component({
  tag: "pyrite-tie-flightgroup",
  styleUrl: "flightgroup.scss",
  shadow: false
})
export class TIEFlightGroupComponent {
  @Prop() public flightGroup: FlightGroup;
  @State() public selectedTab: Tab = Tab.INFO;

  private selectTab(tab: Tab): void {
    this.selectedTab = tab;
  }

  public render() {
    return (
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            {this.flightGroup.CraftTypeLabel} {this.flightGroup.Name}
          </p>
        </header>
        <div class="card-content">
          <div class="tabs">
            <ul>
              {Object.entries(tabs).map(([key, label]) => (
                <li class={`${this.selectedTab === key && "is-active"}`}>
                  <a onClick={this.selectTab.bind(this, key)}>{label}</a>
                </li>
              ))}
            </ul>
          </div>
          <div class="content">
            {this.renderCraftInfo()}
            {this.renderArrivals()}
            {this.renderOrders()}
            {this.renderGoals()}
            {this.renderWaypoints()}
            {this.renderOptions()}
            {this.renderUnknown()}
          </div>
        </div>
      </div>
    );
  }
  private renderCraftInfo(): JSX.Element {
    const fields: { [key: string]: string | number } = {
      Name: this.flightGroup.Name,
      "Craft Type": this.flightGroup.CraftTypeLabel,
      "Number Of Craft": this.flightGroup.NumberOfCraft,
      "Number Of Waves": this.flightGroup.NumberOfWaves,
      Status: this.flightGroup.StatusLabel,
      Warhead: this.flightGroup.WarheadLabel,
      Beam: this.flightGroup.BeamLabel,
      IFF: this.flightGroup.IFFLabel,
      AI: this.flightGroup.GroupAILabel,
      Difficulty: this.flightGroup.ArrivalDifficultyLabel,
      Player: this.flightGroup.PlayerCraft ? "Yes" : "No"
    };
    return (
      <div class={`tab-content ${this.selectedTab === Tab.INFO && "show"}`}>
        <h3>Craft Information</h3>
        {<Field fielder={this.flightGroup} name="Name" />}
        {<Field fielder={this.flightGroup} name="Warhead" />}
        {Object.entries(fields).map((value: [string, string]) => this.renderItem(value[0], value[1]))}
      </div>
    );
  }

  private renderArrivals() {
    const andOr = this.flightGroup.Arrival1OrArrival2 ? "Or" : "And";
    const arrival: { [key: string]: string | number } = {
      Difficulty: this.flightGroup.ArrivalDifficultyLabel,
      Delay: `${this.flightGroup.ArrivalDelayMinutes}:${this.flightGroup.ArrivalDelaySeconds}`,
      Via: this.flightGroup.ArriveViaMothership
        ? this.flightGroup.TIE.getFlightGroup(this.flightGroup.ArrivalMothership).toString()
        : "Hyperspace",
      "Or Via": this.flightGroup.AlternateArriveViaMothership
        ? this.flightGroup.TIE.getFlightGroup(this.flightGroup.AlternateArrivalMothership).toString()
        : "Hyperspace",
      When: this.flightGroup.Arrival1.toString()
    };
    arrival[`${andOr} When`] = this.flightGroup.Arrival2.toString();

    const departure: { [key: string]: string | number } = {
      "Leave after": `${this.flightGroup.DepartureDelayMinutes}:${this.flightGroup.DepartureDelatSeconds}`,
      Via: this.flightGroup.DepartViaMothership
        ? this.flightGroup.TIE.getFlightGroup(this.flightGroup.DepartureMothership).toString()
        : "Hyperspace",
      "Or Via": this.flightGroup.AlternateDepartViaMothership
        ? this.flightGroup.TIE.getFlightGroup(this.flightGroup.AlternateDepartureMothership).toString()
        : "Hyperspace",
      "Abort when": this.flightGroup.AbortTriggerLabel
    };

    if (arrival.Via === arrival["Or Via"]) {
      delete arrival["Or Via"];
    }
    if (departure.Via === departure["Or Via"]) {
      delete departure["Or Via"];
    }

    return (
      <div class={`tab-content ${this.selectedTab === Tab.ARR && "show"}`}>
        <h3>Arrival</h3>
        {Object.entries(arrival).map((value: [string, string]) => this.renderItem(value[0], value[1]))}
        <h3>Departure</h3>
        {Object.entries(departure).map((value: [string, string]) => this.renderItem(value[0], value[1]))}
      </div>
    );
  }

  private renderOrders() {
    return (
      <div class={`tab-content ${this.selectedTab === Tab.ORDERS && "show"}`}>
        <h3>Orders</h3>
        <ol>
          {this.flightGroup.Orders.map((order: Order) => (
            <li>{order.toString()}</li>
          ))}
        </ol>
      </div>
    );
  }

  private renderGoals() {
    const types = ["Primary", "Secondary", "Secret", "Bonus"];

    return (
      <div class={`tab-content ${this.selectedTab === Tab.GOALS && "show"}`}>
        <h3>Goals</h3>
        {this.flightGroup.FlightGroupGoals.map((goal: GoalFG, idx: number) =>
          this.renderItem(types[idx], goal.toString())
        )}
        {this.renderItem("Bonus Points", this.flightGroup.BonusGoalPoints * 50)}
      </div>
    );
  }

  private renderWaypoints() {
    const startPoints = [1, 2, 3, 4];
    const wayPoints = [1, 2, 3, 4, 5, 6, 7, 8];
    const fgwp = this.flightGroup.Waypoints.slice(0, 3);
    const on = this.flightGroup.Waypoints[3];
    return (
      <div class={`tab-content ${this.selectedTab === Tab.WAY && "show"}`}>
        <h3>Waypoints</h3>
        <table>
          {startPoints.map((num, idx) => (
            <tr class={on.StartPoints[idx] ? "show" : "hide"}>
              <td>Start Point #{num}</td>
              {fgwp.map((way: Waypt) => (
                <td>{way.StartPoints[idx] * 0.16}</td>
              ))}
            </tr>
          ))}
          {wayPoints.map((num, idx) => (
            <tr class={on.Waypoints[idx] ? "show" : "hide"}>
              <td>Way Point #{num}</td>
              {fgwp.map((way: Waypt) => (
                <td>{way.Waypoints[idx] * 0.16}</td>
              ))}
            </tr>
          ))}
          <tr class={on.Rendezvous ? "show" : "hide"}>
            <td>Rendezvous Point</td>
            {fgwp.map((way: Waypt) => (
              <td>{way.Rendezvous * 0.16}</td>
            ))}
          </tr>
          <tr class={on.Hyperspace ? "show" : "hide"}>
            <td>Hyperspace Point</td>
            {fgwp.map((way: Waypt) => (
              <td>{way.Hyperspace * 0.16}</td>
            ))}
          </tr>
          <tr class={on.Briefing ? "show" : "hide"}>
            <td>Briefing Point</td>
            {fgwp.map((way: Waypt) => (
              <td>{way.Briefing * 0.16}</td>
            ))}
          </tr>
        </table>
      </div>
    );
  }

  private renderOptions(): JSX.Element {
    const fields: { [key: string]: string | number } = {
      Radio: this.flightGroup.ObeyPlayerOrders ? "Yes" : "No",
      Pilot: this.flightGroup.Pilot,
      Cargo: this.flightGroup.Cargo,
      "Special Cargo": this.flightGroup.SpecialCargo,
      "Special Cargo Craft": this.flightGroup.RandomSpecialCargoCraft ? "Random" : this.flightGroup.SpecialCargoCraft,
      Markings: this.flightGroup.MarkingsLabel,
      Formation: this.flightGroup.FormationLabel,
      "Formation Spacing": this.flightGroup.FormationSpacing,
      "Leader Spacing": this.flightGroup.LeaderSpacing,
      Yaw: this.flightGroup.Yaw,
      Pitch: this.flightGroup.Pitch,
      Roll: this.flightGroup.Roll,
      "Global Group": this.flightGroup.GlobalGroup
    };
    return (
      <div class={`tab-content ${this.selectedTab === Tab.OPT && "show"}`}>
        <h3>Craft Options</h3>
        {Object.entries(fields).map((value: [string, string]) => this.renderItem(value[0], value[1]))}
      </div>
    );
  }

  private renderUnknown(): JSX.Element {
    return (
      <div class={`tab-content ${this.selectedTab === Tab.UNK && "show"}`}>
        <h3>Unknown</h3>
      </div>
    );
  }

  private renderItem(key: string, value: string | number, className?: string): JSX.Element {
    return (
      <div class="field is-horizontal">
        <div class="field-label is-small">
          <label class="label">{key}</label>
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <input class="input is-small" type="text" value={value} />
            </div>
          </div>
        </div>
      </div>
    );
  }
}

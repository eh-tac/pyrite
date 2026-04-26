import { Component, h, JSX, Prop, State } from "@stencil/core";
import { FlightGroup } from "../../../model/TIE";
import { Mission } from "../../../model/TIE/mission";

@Component({
  tag: "pyrite-tie-flightgroups",
  styleUrl: "flightgroups.scss",
  shadow: false
})
export class TIEFlightGroupsComponent {
  @Prop() public mission: Mission;
  @State() public flightGroups: FlightGroup[];
  @State() public selectedFG: FlightGroup;

  public componentWillLoad() {
    this.flightGroups = this.mission.FlightGroups;
    this.selectedFG = this.flightGroups[0];
  }

  protected selectFG(fg: FlightGroup): void {
    this.selectedFG = fg;
  }

  protected fgColor(fg: FlightGroup): string {
    if (fg === this.selectedFG) {
      return "light";
    }
    const colours = ["success", "danger", "primary", "tertiary", "secondary"];
    return colours[fg.Iff];
  }

  public renderFGMenu(fg: FlightGroup): JSX.Element {
    return (
      <li class={`iff-${fg.Iff}`}>
        <a onClick={this.selectFG.bind(this, fg)} class="button py-1">
          <div class="tags has-addons py-1">
            <span class="tag is-info count">{fg.WaveLabel}</span>
            <span class="tag iff">{fg.CraftTypeAbbr}</span>
            <span class="tag iff">{fg.Name}</span>
            <span class="tag is-warning">{fg.ArrivalDifficultyLabel.substr(0, 1)}</span>
          </div>
        </a>
      </li>
    );
  }

  public render() {
    return (
      <div class="columns">
        <div class="menu column is-one-quarter">
          <ul class="menu-list">{this.flightGroups.map(this.renderFGMenu.bind(this))}</ul>
        </div>
        <div class="column">
          <pyrite-tie-flightgroup flightGroup={this.selectedFG} />
        </div>
      </div>
    );
  }
}

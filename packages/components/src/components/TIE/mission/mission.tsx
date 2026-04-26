import { Component, Prop, State, h, Host, JSX, Element } from "@stencil/core";
import { Mission } from "../../../model/TIE";

enum Tab {
  FG = "fgs",
  MESS = "messages",
  GLOBALS = "globals",
  BRIEF = "briefing",
  INFO = "overview"
}

const tabs: { [K in Tab]: string } = {
  fgs: "Flight Groups",
  messages: "Messages",
  globals: "Globals",
  briefing: "Briefing",
  overview: "Overview"
};

@Component({
  tag: "pyrite-tie-mission",
  styleUrl: "mission.scss",
  shadow: false
})
export class TIEMissionComponent {
  @Element() public el: HTMLElement;
  @Prop() public file: string;

  @State() protected tie: Mission;
  @State() protected selectedTab: string = Tab.FG;

  public componentWillLoad(): void {
    if (!this.file) {
      return;
    }
    fetch(this.file)
      .then((res: Response) => res.arrayBuffer())
      .then((value: ArrayBuffer) => {
        this.tie = new Mission(value);
      });
  }

  private selectTab(tab: string): void {
    this.selectedTab = tab;
  }

  public render(): JSX.Element {
    if (!this.tie) {
      return <p>Loading...</p>;
    }
    return (
      <div>
        <h2 class="has-text-centered">Pyrite TIE Editor</h2>
        <hr />
        <div class="tabs">
          <ul>
            {Object.entries(tabs).map(([key, label]) => (
              <li class={`${this.selectedTab === key && "is-active"}`}>
                <a onClick={this.selectTab.bind(this, key)}>{label}</a>
              </li>
            ))}
          </ul>
        </div>
        <div class="tab-contents" data-tab={this.selectedTab}>
          <div class={`tab-content ${this.selectedTab === Tab.FG && "show"}`}>
            <pyrite-tie-flightgroups mission={this.tie}></pyrite-tie-flightgroups>
          </div>
          <div class={`tab-content ${this.selectedTab === Tab.MESS && "show"}`}>
            <pyrite-tie-messages mission={this.tie}></pyrite-tie-messages>
          </div>
          <div class={`tab-content ${this.selectedTab === Tab.GLOBALS && "show"}`}>
            <h3>Globals</h3>
          </div>
          <div class={`tab-content ${this.selectedTab === Tab.BRIEF && "show"}`}>
            <h3>Briefing</h3>
          </div>
          <div class={`tab-content ${this.selectedTab === Tab.INFO && "show"}`}>
            <h3>Mission</h3>
          </div>
        </div>
      </div>
    );
  }
}

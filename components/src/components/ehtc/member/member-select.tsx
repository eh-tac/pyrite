import { JSX, Component, Prop, h, Element, State } from "@stencil/core";
import { PilotSummary } from "../../../model/ehtc";

@Component({
  tag: "ehtc-member-select",
  styleUrl: "member-select.scss",
  shadow: false
})
export class PilotComponent {
  @Element() el: HTMLElement;
  // member PIN = value
  @Prop({ reflect: true }) value: string;
  // domain override. defaults to empty for same domain requests
  @Prop() domain: string;
  @Prop() name: string;

  @State() selection?: PilotSummary;
  @State() suggestions?: PilotSummary[];
  @State() query: string;
  @State() pilotList: PilotSummary[] = [];

  private onInput: (e: Event) => void;
  private externalPINInputElement: HTMLInputElement;

  public componentWillLoad(): void {
    this.onInput = (e: Event) => {
      const input = e.target as HTMLInputElement;
      this.updateQuery(input.value);
    };
    fetch(this.listURL)
      .then((r: Response) => {
        return r.json();
      })
      .then((d: PilotSummary[]) => {
        this.pilotList = d;
      });
    const parent = this.el.parentElement;
    this.externalPINInputElement = parent.ownerDocument.createElement("input");
    this.externalPINInputElement.type = "hidden";
    this.externalPINInputElement.value = this.value;
    this.externalPINInputElement.name = this.name;
    parent.appendChild(this.externalPINInputElement);
  }

  private get listURL(): string {
    const d = this.domain || "";
    return `${d}/api/pilot/list`;
  }

  private updateQuery(query: string): void {
    this.query = query;
    if (this.query) {
      this.getSuggestions();
    } else {
      this.suggestions = undefined;
    }
  }

  private getSuggestions() {
    const q = this.query.toLowerCase();
    const match = (str: string) => str.toLowerCase().includes(q);

    this.suggestions = this.pilotList
      .filter((p: PilotSummary): boolean => {
        return match(p.PIN.toString()) || match(p.label) || match(p.description);
      })
      .slice(0, 15);
  }

  private selectPilot(p?: PilotSummary): void {
    this.selection = p;
    this.externalPINInputElement.value = p ? p.PIN.toString(10) : "";
    this.externalPINInputElement.dispatchEvent(new InputEvent("input"));
  }

  private renderPilot(p: PilotSummary): JSX.Element {
    return (
      <div class="pilot-summary" onClick={this.selectPilot.bind(this, p)}>
        <div class="topline tags has-addons mb-0" style={{ width: "100%" }}>
          <span class="pilot-label tag is-primary mb-0 is-radiusless">{p.label}</span>
          <span class="tag is-info mb-0 is-radiusless">#{p.PIN}</span>
        </div>
        <div class="tag is-primary idline is-radiusless has-text-grey-light">{p.description}</div>
      </div>
    );
  }

  public render(): JSX.Element {
    if (!this.pilotList) {
      return "<p>Loading...</p>";
    }
    return (
      <div class={{ "ehtc-member-select": true, dropdown: true, "is-active": !this.selection && !!this.suggestions }}>
        {!this.selection && (
          <div class="dropdown-trigger field mb-0">
            <div class="control">
              <input class="input" type="text" placeholder="Member search" onInput={this.onInput} value={this.query} />
            </div>
          </div>
        )}
        {this.selection && (
          <div class="selected-pilot">
            {this.renderPilot(this.selection)}
            <a class="button is-warning is-small is-radiusless" onClick={this.selectPilot.bind(this, undefined)}>
              X
            </a>
          </div>
        )}
        <div class="dropdown-menu pt-0" id="dropdown-menu" role="menu">
          <div class="dropdown-content records py-0 is-white">
            {this.suggestions &&
              this.suggestions.map((s: PilotSummary) => <div class="record py-1">{this.renderPilot(s)}</div>)}
            <span class="no-data">No matches found</span>
          </div>
        </div>
      </div>
    );
  }
}

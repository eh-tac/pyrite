import { JSX, Component, Prop, h, Element, State } from "@stencil/core";
import { PilotSummary, CharacterSummary } from "../../../model/ehtc";

type Member = PilotSummary | CharacterSummary;

@Component({
  tag: "ehtc-member-select",
  styleUrl: "member-select.scss",
  shadow: false
})
export class MemberSelectComponent {
  @Element() el: HTMLElement;
  // member PIN = value
  @Prop({ reflect: true }) value: string;
  // domain override. defaults to empty for same domain requests
  @Prop() domain: string;
  @Prop() name: string;
  @Prop() mode: "character" | "pilot" = "character";
  @Prop() filter: string = "";

  @State() selection?: Member;
  @State() suggestions?: Member[];
  @State() query: string;
  @State() memberList: Member[];

  private onInput: (e: Event) => void;
  private externalPINInputElement: HTMLInputElement;
  private filterArray: number[] = [];

  public componentWillLoad(): void {
    this.onInput = (e: Event) => {
      const input = e.target as HTMLInputElement;
      this.updateQuery(input.value);
    };

    const parent = this.el.parentElement;
    this.externalPINInputElement = parent.ownerDocument.createElement("input");
    this.externalPINInputElement.type = "hidden";
    this.externalPINInputElement.value = this.value;
    this.externalPINInputElement.name = this.name;
    parent.appendChild(this.externalPINInputElement);
    this.filterArray = this.filter ? this.filter.split(",").map(s => parseInt(s, 10)) : [];

    fetch(this.listURL)
      .then((r: Response) => {
        return r.json();
      })
      .then((d: Member[]) => {
        this.memberList = d;
        if (this.filterArray.length) {
          this.memberList = d.filter(
            (m: CharacterSummary) =>
              (this.mode === "pilot" && this.filterArray.includes(m.PIN)) ||
              (this.mode === "character" && this.filterArray.includes(m.characterId))
          );
        }

        if (this.value) {
          const v = parseInt(this.value, 10);
          this.selection = this.memberList.find(
            (m: CharacterSummary) =>
              (this.mode === "pilot" && m.PIN === v) || (this.mode === "character" && m.characterId === v)
          );
        }
      });
  }

  private get listURL(): string {
    const d = this.domain || "";
    return `${d}/api/${this.mode}/list`;
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

    this.suggestions = this.memberList
      .filter((p: Member): boolean => {
        return match(p.PIN.toString()) || match(p.label) || match(p.description);
      })
      .slice(0, 15);
  }

  private selectMember(m?: Member): void {
    this.selection = m;
    let val = "";
    if (m) {
      const num = this.mode === "character" ? (m as CharacterSummary).characterId : m.PIN;
      val = num.toString(10);
    }
    this.externalPINInputElement.value = val;
    this.externalPINInputElement.dispatchEvent(new InputEvent("input"));
  }

  private renderMember(p: Member): JSX.Element {
    return (
      <div class="pilot-summary" onClick={this.selectMember.bind(this, p)}>
        <div class="topline tags has-addons mb-0" style={{ width: "100%" }}>
          <span class="pilot-label tag is-primary mb-0 is-radiusless">{p.label}</span>
          <span class="tag is-info mb-0 is-radiusless">#{p.PIN}</span>
        </div>
        <div class="tag is-primary idline is-radiusless has-text-grey-light">{p.description}</div>
      </div>
    );
  }

  public render(): JSX.Element {
    if (!this.memberList) {
      return <p>Loading...</p>;
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
            {this.renderMember(this.selection)}
            <a class="button is-warning is-small is-radiusless" onClick={this.selectMember.bind(this, undefined)}>
              X
            </a>
          </div>
        )}
        <div class="dropdown-menu pt-0" id="dropdown-menu" role="menu">
          <div class="dropdown-content records py-0 is-white">
            {this.suggestions &&
              this.suggestions.map((s: Member) => <div class="record py-1">{this.renderMember(s)}</div>)}
            <span class="no-data">No matches found</span>
          </div>
        </div>
      </div>
    );
  }
}

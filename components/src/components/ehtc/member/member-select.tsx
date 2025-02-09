import { JSX, Component, Prop, h, Element, Event, EventEmitter, State, Method } from "@stencil/core";
import { PilotSummary, CharacterSummary } from "../../../model/ehtc";
import { ehtcAPI } from "../api-store/util";

type Member = PilotSummary | CharacterSummary;

@Component({
  tag: "ehtc-member-select",
  styleUrl: "member-select.scss",
  shadow: false
})
export class MemberSelectComponent {
  @Element() el: HTMLElement;
  @Event() memberSelect: EventEmitter<PilotSummary | CharacterSummary>;
  // member PIN = value
  @Prop({ reflect: true, mutable: true }) value: string;
  // domain override. defaults to empty for same domain requests
  @Prop() domain: string;
  @Prop() name: string;
  @Prop() mode: "character" | "pilot" | "group-characters" = "character";
  @Prop() status: "active" | "all" = "active";
  @Prop() filter: string = "";
  @Prop() disabled: boolean;
  @Prop() readonly: boolean;
  @State() selection?: Member;
  @State() suggestions?: Member[];
  @State() suggestionIdx?: number;
  @State() query: string;
  @State() memberList: Member[];

  private onInput: (e: Event) => void = (e: Event) => {
    if (this.disabled) {
      return;
    }
    const input = e.target as HTMLInputElement;
    this.updateQuery(input.value);
  };
  private onKeyDown: (e: KeyboardEvent) => void = (e: KeyboardEvent) => {
    if (!this.suggestions) {
      return;
    }

    if (e.key === "ArrowDown") {
      if (this.suggestionIdx === undefined) {
        this.suggestionIdx = 0;
      } else {
        this.suggestionIdx++;
        if (this.suggestionIdx === this.suggestions.length) {
          this.suggestionIdx = 0; // wrap around
        }
      }
    } else if (e.key === "ArrowUp") {
      if (this.suggestionIdx === undefined) {
        this.suggestionIdx = this.suggestions.length - 1;
      } else {
        this.suggestionIdx--;
        if (this.suggestionIdx === -1) {
          this.suggestionIdx = this.suggestions.length - 1; // wrap around
        }
      }
    } else if (e.key === "Enter") {
      e.stopPropagation();
      e.preventDefault();
      const m = this.suggestions[this.suggestionIdx];
      if (m) {
        this.selectMember(m);
      }
    }
  };
  private externalPINInputElement: HTMLInputElement;
  private filterArray: number[] = [];

  private get editable(): boolean {
    return !this.disabled && !this.readonly;
  }

  public componentWillLoad(): void {
    const parent = this.el.parentElement;
    this.externalPINInputElement = parent.ownerDocument.createElement("input");
    this.externalPINInputElement.type = "hidden";
    this.externalPINInputElement.value = this.value;
    this.externalPINInputElement.name = this.name;
    this.externalPINInputElement.disabled = this.disabled;
    this.externalPINInputElement.readOnly = this.readonly;

    parent.appendChild(this.externalPINInputElement);
    this.filterArray = this.filter ? this.filter.split(",").map(s => parseInt(s, 10)) : [];

    ehtcAPI(this.listURL).then((d: Member[]) => {
      this.memberList = d;
      if (this.filterArray.length) {
        this.memberList = d.filter(
          (m: CharacterSummary) =>
            (this.mode !== "character" && this.filterArray.includes(m.PIN)) ||
            (this.mode === "character" && this.filterArray.includes(m.characterId))
        );
      }

      if (this.value) {
        this.setValue(this.value);
      }
    });

    document.body.addEventListener("keydown", (ke: KeyboardEvent) => {
      if (ke.key === "Escape" && this.suggestions) {
        this.suggestions = undefined;
      }
    });
  }

  @Method()
  public search(query: string): Promise<void> {
    this.updateQuery(query);
    return Promise.resolve();
  }

  @Method()
  public setValue(val: string | number): Promise<void> {
    const v = typeof val === "number" ? val : parseInt(val, 10);
    this.selectMember(
      this.memberList.find(
        (m: CharacterSummary) =>
          (this.mode !== "character" && m.PIN === v) || (this.mode === "character" && m.characterId === v)
      )
    );
    return Promise.resolve();
  }

  private get listURL(): string {
    const d = this.domain || "";

    if (this.mode === "group-characters") {
      return `${d}/api/member/characters/${this.status}`;
    }

    return `${d}/api/${this.mode}/list/${this.status}`;
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
    const match = (str?: string) => str && str.toLowerCase().includes(q);
    const exact = (str?: string) => str && str.toLowerCase() === q;
    const score = (str?: string) => (match(str) ? str.toLowerCase().indexOf(q) : 99);
    const nactv = (m: Member) => m.description.includes("[Inactive]");

    // PIN > 1 excludes the system profile
    const filtered = this.memberList.filter((p: Member): boolean => {
      return p.PIN > 1 && (match(p.PIN.toString()) || match(p.label) || match(p.description));
    });
    const sorted = filtered.sort((a: Member, b: Member): number => {
      if (exact(a.PIN.toString()) || exact(a.label) || exact(a.description)) return -1;
      if (exact(b.PIN.toString()) || exact(b.label) || exact(b.description)) return 1;
      if (nactv(a)) return 1;
      if (nactv(b)) return -1;

      const aScore = Math.min(score(a.PIN.toString()), score(a.label), score(a.description));
      const bScore = Math.min(score(b.PIN.toString()), score(b.label), score(b.description));
      return aScore - bScore;
    });
    this.suggestions = sorted.slice(0, 15);
    document.body.addEventListener(
      "click",
      () => {
        this.suggestions = undefined;
      },
      { once: true }
    );
    this.suggestionIdx = undefined;
  }

  private selectMember(m?: Member): void {
    this.selection = m;
    let val = "";
    if (m) {
      const num = this.mode === "character" ? (m as CharacterSummary).characterId : m.PIN;
      val = num.toString(10);
    }
    this.value = val;
    this.memberSelect.emit(m);
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
        <div class="tag is-primary idline is-radiusless has-text-light">{p.description}</div>
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
              <input
                class="input"
                type="text"
                placeholder="Member search"
                onInput={this.onInput}
                onKeyDown={this.onKeyDown}
                value={this.query}
                disabled={this.disabled}
                readOnly={this.readonly}
              />
            </div>
          </div>
        )}
        {this.selection && (
          <div class="selected-pilot">
            {this.renderMember(this.selection)}
            {this.editable && (
              <a class="button is-warning is-small is-radiusless" onClick={this.selectMember.bind(this, undefined)}>
                X
              </a>
            )}
          </div>
        )}
        <div class="dropdown-menu pt-0" id="dropdown-menu" role="menu">
          <div class="dropdown-content records py-0 is-white">
            {this.suggestions &&
              this.suggestions.map((s: Member, idx: number) => (
                <div class={{ record: true, hover: this.suggestionIdx === idx }}>{this.renderMember(s)}</div>
              ))}
            <span class="no-data">No matches found</span>
          </div>
        </div>
      </div>
    );
  }
}

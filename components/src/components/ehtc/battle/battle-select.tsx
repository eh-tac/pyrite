import { JSX, Component, Prop, h, Element, State, Method, Event, EventEmitter } from "@stencil/core";
import { BattleSummary } from "../../../model/ehtc";
import { ehtcAPI } from "../api-store/util";

@Component({
  tag: "ehtc-battle-select",
  styleUrl: "battle-select.scss",
  shadow: false
})
export class BattleSelectComponent {
  @Element() el: HTMLElement;
  @Event() battleSelect: EventEmitter<BattleSummary>;

  // battle id = value
  @Prop({ reflect: true, mutable: true }) value: string;
  @Prop({ reflect: true }) battle: BattleSummary;
  @Prop() category: string;
  // domain override. defaults to empty for same domain requests
  @Prop() domain: string;
  @Prop() name: string;
  @Prop() disabled: boolean;
  @Prop() readonly: boolean;

  @State() selection?: BattleSummary;
  @State() suggestions?: BattleSummary[];
  @State() suggestionIdx?: number;
  @State() query: string;
  @State() battleList: BattleSummary[];

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
        this.selectBattle(m);
      }
    }
  };

  private externalInputElement: HTMLInputElement;

  private get editable(): boolean {
    return !this.disabled && !this.readonly;
  }

  public componentWillLoad(): void {
    ehtcAPI(this.listURL).then((d: BattleSummary[]) => {
      this.battleList = d;
      if (this.value) {
        const v = parseInt(this.value, 10);
        this.selection = this.battleList.find((m: BattleSummary) => m.id === v);
      }
    });
    const parent = this.el.parentElement;
    this.externalInputElement = parent.ownerDocument.createElement("input");
    this.externalInputElement.type = "hidden";
    this.externalInputElement.value = this.value;
    this.externalInputElement.name = this.name;
    this.externalInputElement.disabled = this.disabled;
    this.externalInputElement.readOnly = this.readonly;

    parent.appendChild(this.externalInputElement);
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
    this.selectBattle(this.battleList.find((m: BattleSummary) => m.id === v || m.code === val));
    return Promise.resolve();
  }

  private get listURL(): string {
    const d = this.domain || "";
    const c = this.category ? `/${this.category}` : "";
    return `${d}/api/battles/list${c}`;
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
    const match = (str: string) => {
      const s = str.toLowerCase();
      const t = s.replace("-", "");
      const u = t.replace(" ", "");
      return s.includes(q) || t.includes(q) || u.includes(q);
    };

    this.suggestions = this.battleList
      .filter((b: BattleSummary): boolean => {
        return match(b.id.toString()) || match(b.name) || match(b.code);
      })
      .slice(0, 15);
    document.body.addEventListener(
      "click",
      () => {
        this.suggestions = undefined;
      },
      { once: true }
    );
    this.suggestionIdx = undefined;
  }

  private selectBattle(b?: BattleSummary): void {
    this.selection = b;
    this.value = this.externalInputElement.value = b ? b.id.toString(10) : "";
    this.battleSelect.emit(b);
    this.externalInputElement.dispatchEvent(new InputEvent("input"));
  }

  private renderBattle(b: BattleSummary): JSX.Element {
    return (
      <div class="battle-summary" onClick={this.selectBattle.bind(this, b)}>
        <div class="topline tags has-addons" style={{ width: "100%" }}>
          <span class="battle-code tag is-info mb-0 is-radiusless">#{b.code}</span>
          <span class="battle-label tag is-primary mb-0 is-radiusless">{b.name}</span>
        </div>
      </div>
    );
  }

  public render(): JSX.Element {
    if (!this.battleList) {
      return <p>Loading...</p>;
    }
    return (
      <div class={{ "ehtc-battle-select": true, dropdown: true, "is-active": !this.selection && !!this.suggestions }}>
        {!this.selection && (
          <div class="dropdown-trigger field mb-0">
            <div class="control">
              <input
                class="input"
                type="text"
                placeholder="Battle search"
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
          <div class="selected-battle">
            {this.renderBattle(this.selection)}
            {this.editable && (
              <a class="button is-warning is-small is-radiusless" onClick={this.selectBattle.bind(this, undefined)}>
                X
              </a>
            )}
          </div>
        )}
        <div class="dropdown-menu pt-0" id="dropdown-menu" role="menu">
          <div class="dropdown-content records py-0 is-white">
            {this.suggestions &&
              this.suggestions.map((s: BattleSummary, idx: number) => (
                <div class={{ record: true, hover: this.suggestionIdx === idx }}>{this.renderBattle(s)}</div>
              ))}
            <span class="no-data">No matches found</span>
          </div>
        </div>
      </div>
    );
  }
}

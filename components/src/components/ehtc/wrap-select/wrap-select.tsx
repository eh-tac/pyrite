import { JSX, Component, Prop, h, Element, State, Method, Event, EventEmitter } from "@stencil/core";

export interface ItemSummary {
  id: number;
  name: string;
}

@Component({
  tag: "ehtc-wrap-select",
  styleUrl: "wrap-select.scss",
  shadow: false
})
export class WrapSelectComponent {
  @Element() el: HTMLElement;
  @Event() itemSelect: EventEmitter<ItemSummary>;

  @Prop({ reflect: true, mutable: true }) value: string;
  @Prop({ reflect: true }) item: ItemSummary;
  @Prop() name: string;
  @Prop() disabled: boolean;
  @Prop() readonly: boolean;

  @State() selection?: ItemSummary;
  @State() suggestions?: ItemSummary[];
  @State() suggestionIdx?: number;
  @State() query: string;
  @State() fullList: ItemSummary[];

  private onInput: (e: Event) => void = (e: Event) => {
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
      const m = this.suggestions[this.suggestionIdx];
      if (m) {
        this.selectItem(m);
      }
    }
  };
  private onClick: (e: Event) => void = (e: Event) => {
    if (this.disabled) {
      return;
    }

    if (this.query) {
      this.getSuggestions();
    } else {
      this.suggestions = this.fullList;
      document.body.addEventListener(
        "click",
        () => {
          this.suggestions = undefined;
        },
        { once: true }
      );
    }
    e.stopPropagation();
  };

  private externalInputElement: HTMLInputElement;

  private get editable(): boolean {
    return !this.disabled && !this.readonly;
  }

  public componentWillLoad(): void {
    this.fullList = [];

    const parent = this.el.parentElement;
    this.externalInputElement = parent.ownerDocument.createElement("input");
    this.externalInputElement.type = "hidden";
    this.externalInputElement.value = this.value;
    this.externalInputElement.name = this.name;
    this.externalInputElement.disabled = this.disabled;
    this.externalInputElement.readOnly = this.readonly;
    parent.appendChild(this.externalInputElement);

    this.el.querySelectorAll("option").forEach(optEl => {
      const item = {
        id: optEl.value ? parseInt(optEl.value, 10) : null,
        name: optEl.textContent
      };
      if (item.id) {
        // skip blanks
        this.fullList.push(item);
        if (optEl.selected) {
          // select the initially selected value
          this.selectItem(item);
        }
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

    this.suggestions = this.fullList
      .filter((b: ItemSummary): boolean => {
        return match(b.id ? b.id.toString() : "") || match(b.name);
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

  private selectItem(b?: ItemSummary): void {
    this.selection = b;
    this.value = this.externalInputElement.value = b ? b.id.toString(10) : "";
    this.itemSelect.emit(b);
    this.externalInputElement.dispatchEvent(new InputEvent("input"));
  }

  private renderItem(b: ItemSummary): JSX.Element {
    return (
      <div class="item-summary" onClick={this.selectItem.bind(this, b)}>
        <div class="topline tags has-addons" style={{ width: "100%" }}>
          <span class="item-label tag is-primary mb-0 is-radiusless">{b.name}</span>
        </div>
      </div>
    );
  }

  public render(): JSX.Element {
    if (!this.fullList) {
      return (
        <p>
          Loading...
          <slot />
        </p>
      );
    }
    return (
      <div
        class={{ "ehtc-wrap-select": true, dropdown: true, "is-active": !this.selection && !!this.suggestions }}
        onClick={this.onClick}
      >
        <div style={{ display: "none" }}>
          <slot />
        </div>
        {!this.selection && (
          <div class="dropdown-trigger field mb-0">
            <div class="control">
              <input
                class="input"
                type="text"
                placeholder="Search"
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
          <div class="selected-item">
            {this.renderItem(this.selection)}
            {this.editable && (
              <a class="button is-warning is-small is-radiusless" onClick={this.selectItem.bind(this, undefined)}>
                X
              </a>
            )}
          </div>
        )}
        <div class="dropdown-menu pt-0" id="dropdown-menu" role="menu">
          <div class="dropdown-content records py-0 is-white">
            {this.suggestions &&
              this.suggestions.map((s: ItemSummary, idx: number) => (
                <div class={{ record: true, hover: this.suggestionIdx === idx }}>{this.renderItem(s)}</div>
              ))}
            <span class="no-data">No matches found</span>
          </div>
        </div>
      </div>
    );
  }
}

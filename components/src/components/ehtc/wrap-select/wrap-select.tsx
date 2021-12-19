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

  @Prop({ reflect: true }) value: string;
  @Prop({ reflect: true }) item: ItemSummary;
  @Prop() name: string;

  @State() selection?: ItemSummary;
  @State() suggestions?: ItemSummary[];
  @State() query: string;
  @State() fullList: ItemSummary[];

  private onInput: (e: Event) => void = (e: Event) => {
    const input = e.target as HTMLInputElement;
    this.updateQuery(input.value);
  };

  private onClick: (e: Event) => void = (e: Event) => {
    if (this.query) {
      this.getSuggestions();
    } else {
      this.suggestions = this.fullList;
    }
    e.stopPropagation();
  };

  private externalInputElement: HTMLInputElement;

  public componentWillLoad(): void {
    this.fullList = [];

    const parent = this.el.parentElement;
    this.externalInputElement = parent.ownerDocument.createElement("input");
    this.externalInputElement.type = "hidden";
    this.externalInputElement.value = this.value;
    this.externalInputElement.name = this.name;
    parent.appendChild(this.externalInputElement);

    this.el.querySelectorAll("option").forEach(optEl => {
      const item = {
        id: optEl.value ? parseInt(optEl.value, 10) : null,
        name: optEl.textContent
      };
      this.fullList.push(item);
      if (optEl.selected) {
        this.selectItem(item);
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
              <input class="input" type="text" placeholder="Search" onInput={this.onInput} value={this.query} />
            </div>
          </div>
        )}
        {this.selection && (
          <div class="selected-item">
            {this.renderItem(this.selection)}
            <a class="button is-warning is-small is-radiusless" onClick={this.selectItem.bind(this, undefined)}>
              X
            </a>
          </div>
        )}
        <div class="dropdown-menu pt-0" id="dropdown-menu" role="menu">
          <div class="dropdown-content records py-0 is-white">
            {this.suggestions &&
              this.suggestions.map((s: ItemSummary) => <div class="record">{this.renderItem(s)}</div>)}
            <span class="no-data">No matches found</span>
          </div>
        </div>
      </div>
    );
  }
}

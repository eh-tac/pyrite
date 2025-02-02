import { JSX, Component, Prop, h, Element, State, Method, Event, EventEmitter } from "@stencil/core";
import { ehtcAPI } from "../api-store/util";

export interface ApiSummary {
  id: number;
  name: string;
}

@Component({
  tag: "ehtc-api-select",
  styleUrl: "api-select.scss",
  shadow: false
})
export class ApiSelectComponent {
  @Element() el: HTMLElement;
  @Event() apiSelect: EventEmitter<ApiSummary>;

  @Prop({ reflect: true }) value: string;
  @Prop({ reflect: true }) item: ApiSummary;
  // domain override. defaults to empty for same domain requests
  @Prop() domain: string;
  @Prop() name: string;
  @Prop() url: string;

  @State() selection?: ApiSummary;
  @State() suggestions?: ApiSummary[];
  @State() query: string;
  @State() fullList: ApiSummary[];

  private onInput: (e: Event) => void;
  private externalInputElement: HTMLInputElement;

  public componentWillLoad(): void {
    this.onInput = (e: Event) => {
      const input = e.target as HTMLInputElement;
      this.updateQuery(input.value);
    };
    ehtcAPI(this.listURL).then((d: ApiSummary[]) => {
      this.fullList = d;
      if (this.value) {
        const v = parseInt(this.value, 10);
        this.selection = this.fullList.find((m: ApiSummary) => m.id === v);
      }
    });
    const parent = this.el.parentElement;
    this.externalInputElement = parent.ownerDocument.createElement("input");
    this.externalInputElement.type = "hidden";
    this.externalInputElement.value = this.value;
    this.externalInputElement.name = this.name;
    parent.appendChild(this.externalInputElement);
  }

  @Method()
  public search(query: string): Promise<void> {
    this.updateQuery(query);
    return Promise.resolve();
  }

  @Method()
  public setValue(val: string | number): Promise<void> {
    const v = typeof val === "number" ? val : parseInt(val, 10);
    this.selectItem(
      this.fullList.find((m: ApiSummary) => m.id === v || m.name.toLowerCase() === val.toString().toLowerCase())
    );
    return Promise.resolve();
  }

  private get listURL(): string {
    const d = this.domain || "";
    return `${d}${this.url}`;
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
      .filter((b: ApiSummary): boolean => {
        return match(b.id.toString()) || match(b.name);
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

  private selectItem(b?: ApiSummary): void {
    this.selection = b;
    this.value = this.externalInputElement.value = b ? b.id.toString(10) : "";
    this.apiSelect.emit(b);
    this.externalInputElement.dispatchEvent(new InputEvent("input"));
  }

  private renderItem(b: ApiSummary): JSX.Element {
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
      return <p>Loading...</p>;
    }
    return (
      <div class={{ "ehtc-api-select": true, dropdown: true, "is-active": !this.selection && !!this.suggestions }}>
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
              this.suggestions.map((s: ApiSummary) => <div class="record">{this.renderItem(s)}</div>)}
            <span class="no-data">No matches found</span>
          </div>
        </div>
      </div>
    );
  }
}

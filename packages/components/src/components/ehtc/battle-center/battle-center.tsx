import { Component, h, State } from "@stencil/core";
import { JSX } from "../../../components";
import { Config } from "../../../config";
import { BattleType, BattleSummary, Battle } from "../../../model/ehtc";
import { ehtcAPI } from "../api-store/util";

@Component({
  tag: "ehtc-battle-center",
  styleUrl: "battle-center.scss",
  shadow: true
})
export class BattleCenterComponent {
  @State() public page: string;
  @State() public platform: string;
  @State() public typeData: BattleType[];
  @State() public type: BattleType;
  @State() public listData: BattleSummary[];
  @State() public battle: BattleSummary;

  private fullBattle: Battle;

  private get typeUrl(): string {
    return `${Config.ROOT}/api/battle-types/${this.platform}`;
  }

  private get listUrl(): string {
    return `${Config.ROOT}${this.type.URL}`;
  }

  private get battleUrl(): string {
    return `${Config.ROOT}${this.battle.URL}`;
  }

  public render(): JSX.IntrinsicElements {
    let title: string = "";
    let content: JSX.IntrinsicElements;
    let back = "Back";
    if (this.page === "battle") {
      title = this.battle.name;
      content = this.renderBattle();
    } else if (this.page === "battle-list") {
      title = `${this.type.platform} - ${this.type.subgroup}`;
      content = this.renderList();
    } else if (this.page === "battle-types" && this.platform) {
      title = this.typeData && this.typeData.length ? this.typeData[0].platform : this.platform;
      content = this.renderTypes();
    } else {
      title = "Game platforms";
      content = this.renderPlatforms();
      back = "";
    }
    const button = back ? (
      <button type="button" class="btn btn-secondary" onClick={this.navigateBack.bind(this)}>
        {back}
      </button>
    ) : (
      ""
    );
    return (
      <div class="component bg-dark">
        <nav class="navbar navbar-light bg-light">
          {button}
          <a class="navbar-brand" href="#">
            {title}
          </a>
        </nav>
        <div class="container">{content}</div>
      </div>
    );
  }

  private navigateBack(): void {
    if (this.page === "battle-types") {
      this.page = "platforms";
    } else if (this.page === "battle-list") {
      this.page = "battle-types";
    } else if (this.page === "battle") {
      this.page = "battle-list";
    }
  }

  private renderPlatforms(): JSX.IntrinsicElements {
    return (
      <div class="platforms">
        <div class="row">
          <div class="col-sm p-3">
            <button
              class="btn btn-large btn-secondary border-warning  btn-block py-3"
              onClick={this.selectPlatform.bind(this, "XW")}
            >
              <h1 class="text-warning mb-0 lh-6">X-Wing</h1>
            </button>
          </div>
          <div class="col-sm p-3">
            <button
              class="btn btn-large btn-secondary border-warning btn-block py-3"
              onClick={this.selectPlatform.bind(this, "TIE")}
            >
              <h1 class="text-warning mb-0">
                TIE <br />
                Fighter
              </h1>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-sm twin p-3">
            <button
              class="btn btn-large btn-secondary border-warning w-50 py-3"
              onClick={this.selectPlatform.bind(this, "XvT")}
            >
              <h1 class="text-warning mb-0">X-Wing vs TIE Fighter</h1>
            </button>
            <button
              class="btn btn-large btn-secondary border-left-0 border-warning w-50 py-3"
              onClick={this.selectPlatform.bind(this, "BoP")}
            >
              <h1 class="text-warning mb-0">Balance of Power</h1>
            </button>
          </div>
          <div class="col-sm p-3">
            <button
              class="btn btn-large btn-secondary rounded border-warning btn-block py-3"
              onClick={this.selectPlatform.bind(this, "XWA")}
            >
              <h1 class="text-warning mb-0">
                X-Wing
                <br />
                Alliance
              </h1>
            </button>
          </div>
        </div>
      </div>
    );
  }

  private selectPlatform(platform: string, event: MouseEvent): void {
    this.platform = platform;

    ehtcAPI(this.typeUrl).then(data => {
      this.typeData = data;
      this.page = "battle-types";
    });
  }

  private renderTypes(): JSX.IntrinsicElements {
    return (
      <table class="table table-hover table-striped types">
        <tbody>
          {this.typeData.map((type: BattleType) => (
            <tr key={type.code} onClick={this.selectType.bind(this, type)}>
              <td class="code" slot="start" color="secondary">
                {type.code}
              </td>
              <td>
                {type.platform} - {type.subgroup}
              </td>
              <td slot="end" color="secondary">
                {type.count}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    );
  }

  private selectType(type: BattleType, event: MouseEvent): void {
    this.type = type;
    const item = event.target as HTMLElement;
    item.innerHTML = "<ion-spinner name='dots' />";

    ehtcAPI(this.listUrl).then(data => {
      this.listData = data;
      this.page = "battle-list";
    });
  }

  private renderList(): JSX.IntrinsicElements {
    return (
      <table class="table table-hover table-striped types">
        <tbody>
          {this.listData.map((battle: BattleSummary) => (
            <tr key={battle.code} onClick={this.selectBattle.bind(this, battle)}>
              <td class="code" slot="start" color="secondary">
                {battle.code}
              </td>
              <td>
                <h3>{battle.name}</h3>
                <p>{battle.missions} missions</p>
              </td>
              <td slot="end" color="secondary">
                {battle.ratingAvg}
                {/* <ion-icon name="star"></ion-icon> */}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    );
  }

  private selectBattle(battle: BattleSummary, _event: MouseEvent): void {
    this.battle = battle;
    // const item = event.target as HTMLIonItemElement;
    // item.innerHTML = "<ion-spinner name='dots' />";

    ehtcAPI(this.battleUrl).then(data => {
      this.fullBattle = data;
      this.page = "battle";
    });
  }

  private renderBattle(): JSX.IntrinsicElements {
    return <ehtc-battle battle={this.fullBattle} />;
  }
}

import { Component, h, Prop, State, Listen, Event, EventEmitter } from "@stencil/core";
import { JSX } from "../../../components";
import { Battle, Review, Bug, Score } from "../../../model/ehtc/battle";
import { PilotSummary } from "../../../model/ehtc/pilot";

@Component({
  tag: "ehtc-battle",
  styleUrl: "battle.scss",
  shadow: true
})
export class BattleComponent {
  @Prop({ mutable: true }) battle: Battle;
  @Prop() code: string;

  @State() tab: string = "info";

  @Event() downloadBattle: EventEmitter<Battle>;

  public componentWillLoad(): void {
    // TODO if battle not set, load from code
  }

  @Listen("ionChange")
  public tabSelect(e: CustomEvent<any>): void {
    this.tab = e.detail.value;
  }

  private download(): void {
    this.downloadBattle.emit(this.battle);
  }

  public render(): JSX.IntrinsicElements {
    if (!this.battle) {
      return <p>Loading...</p>;
    }
    return (
      <div class={this.tab}>
        <ul class="nav nav-pills mb-3" id="battle-tabs" role="tablist">
          <li class="nav-item" value="info">
            <a class="nav-link active" id="nav-battle-info" data-toggle="pill" href="#battle-info" role="tab">
              Information
            </a>
          </li>
          <li class="nav-item" value="reviews">
            <a class="nav-link" id="nav-battle-reviews" data-toggle="pill" href="#battle-reviews" role="tab">
              Reviews
            </a>
          </li>
          <li class="nav-item" value="bugs">
            <a class="nav-link" id="nav-battle-bugs" data-toggle="pill" href="#battle-bugs" role="tab">
              Bugs
            </a>
          </li>
          <li class="nav-item" value="scores">
            <a class="nav-link" id="nav-battle-scores" data-toggle="pill" href="#battle-scores" role="tab">
              High Scores
            </a>
          </li>
          <li class="nav-item" value="stats">
            <a class="nav-link" id="nav-battle-stats" data-toggle="pill" href="#battle-stats" role="tab">
              Statistics
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active info" id="battle-info" role="tabpanel">
            {this.renderInfo()}
          </div>
          <div class="tab-pane fade show active reviews" id="battle-reviews" role="tabpanel">
            {this.renderReviews()}
          </div>
          <div class="tab-pane fade showactive bugs" id="battle-bugs" role="tabpanel">
            {this.renderBugs()}
          </div>
          <div class="tab-pane fade show active scores" id="battle-scores" role="tabpanel">
            {this.renderScores()}
          </div>
          <div class="tab-pane fade stats active" id="battle-stats" role="tabpanel"></div>
        </div>
      </div>
    );
  }

  private renderInfo(): JSX.IntrinsicElements {
    const fields: { [key: string]: string | number } = {
      Missions: this.battle.missions,
      "Date added": this.battle.added,
      "Date updated": this.battle.updated
    };

    return (
      <div class="list-group info">
        <h5>Details</h5>
        {Object.entries(fields).map((value: [string, string]) => this.renderItem(value[0], value[1]))}
        <h5>Creators</h5>
        {this.battle.creators.map((value: PilotSummary) => this.renderItem(value.PIN, value.label))}
        <h5>Patches</h5>
        {this.battle.patches.map((value: string) => this.renderItem("", value))}
        <button class="btn btn-primary btn-block" onClick={this.download.bind(this)}>
          Download
        </button>
      </div>
    );
  }

  private renderReviews(): JSX.IntrinsicElements {
    return (
      <div class="list-group reviews">
        {this.battle.reviews.map((review: Review) => (
          <div class="list-group-item p-1 d-flex justify-content-between">
            <span class="text-muted p-1">{review.date}</span>
            <div class="flex-fill p-1">
              <h5>{review.pilot.label}</h5>
              <p class="review">{review.review}</p>
            </div>
            <span class="p-1 badge btn-primary">
              {review.rating}
              <ion-icon name="star"></ion-icon>
            </span>
          </div>
        ))}
      </div>
    );
  }

  private renderBugs(): JSX.IntrinsicElements {
    return (
      <div class="list-group bugs">
        {this.battle.bugs.map((review: Bug) => (
          <div class="list-group-item p-1 d-flex justify-content-between">
            <span class="text-muted p-1">{review.date}</span>
            <div class="flex-fill px-2">
              <h5>{review.pilot.label}</h5>
              <p class="review">{review.report}</p>
            </div>
          </div>
        ))}
      </div>
    );
  }

  private renderScores(): JSX.IntrinsicElements {
    return (
      <div class="list-group scores">
        <span class="text-muted p-1">{`Battle Total`}</span>
        <div class="flex-fill px-2">
          <h5>{this.battle.highScores.total.pilot.label}</h5>
          <p>{this.battle.highScores.total.date}</p>
        </div>
        <span class="badge">{this.battle.highScores.total.score}</span>
        {this.battle.highScores.missions.map((score: Score, idx: number) => (
          <div class="list-group-item p-1 d-flex justify-content-between">
            <span class="text-muted p-1">{`Mission ${idx + 1}`}</span>
            <div class="flex-fill px-2">
              <h5>{score.pilot.label}</h5>
              <p>{score.date}</p>
            </div>
            <span class="badge">{score.score}</span>
          </div>
        ))}
      </div>
    );
  }

  private renderItem(key: string | number, value: string | number, className?: string): JSX.IntrinsicElements {
    return (
      <div class={`list-group-item ${className}`}>
        <h6>{key}</h6>
        <small class="text-muted">{value}</small>
      </div>
    );
  }
}

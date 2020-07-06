import { Component, Prop, h, Watch, State } from "@stencil/core";
import { Config } from "../../../config";
import { Pilot } from "../../../model/ehtc";

@Component({
  tag: "ehtc-pilot",
  styleUrl: "pilot.scss",
  shadow: true
})
export class PilotComponent {
  @Prop() pin: number;
  @Prop() secondary: boolean;
  @State() data: Pilot;

  public componentWillLoad(): void {
    this.loadPilot();
  }

  private get pilotUrl(): string {
    return `${Config.ROOT}/api/pilot/${this.pin}`;
  }

  private get rankImg(): string {
    const rank = this.secondary
      ? this.data.secondary.rankImage
      : this.data.rankImage;
    return `${Config.ROOT}${rank}`;
  }

  private get rank(): string {
    return this.secondary ? this.data.secondary.rank : this.data.rank;
  }

  private get IDLine(): string {
    return this.secondary ? this.data.secondary.IDLine : this.data.IDLine;
  }

  private get extraLine(): string {
    return this.secondary
      ? this.data.IDLine
      : this.data.secondary
      ? this.data.secondary.IDLine
      : "";
  }

  private get fchgImg(): string {
    return `${Config.ROOT}${this.data.FCHG.image}`;
  }

  @Watch("pin")
  private loadPilot(): void {
    this.data = undefined;
    fetch(this.pilotUrl)
      .then(res => res.json())
      .then((pilot: Pilot) => {
        this.data = pilot;
      });
  }

  public render() {
    if (!this.data) {
      return (
        <div>
          <p>Loading {this.pin}...</p>
        </div>
      );
    }

    return (
      <div class="wrapper">
        <div class="left">
          <img src={this.rankImg} class="rank" />
          <span class="subtitle rank">{this.rank}</span>
          <img src={this.fchgImg} class="fchg" />
          <span class="subtitle fchg">
            {this.data.FCHG.label}{" "}
            <span class="total">({this.data.FCHG.total})</span>
          </span>
        </div>
        <div class="right">
          <div class="name">
            <h3>{this.data.name}</h3>
            <span class="pin">#{this.data.PIN}</span>
          </div>
          <p class="id">{this.data.IDLine}</p>
          <p class="id">{this.extraLine}</p>
        </div>
      </div>
    );
  }
}

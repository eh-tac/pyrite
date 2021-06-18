import { Component, Element, h, Host, JSX, Prop, State, Watch } from "@stencil/core";
import { Briefing, Event, Mission, Tag, TIEString } from "../../../model/TIE";
import { EventType } from "../../../model/TIE/event";
import { FontFile } from "../../../model/util/font";
import { DrawingObject } from "../../../view-model/drawing-object";
import { DrawFGTag } from "./draw-fg-tag";
import { DrawTextTag } from "./draw-text-tag";
import { TIEDrawMap } from "./tie-map";

@Component({
  tag: "pyrite-tie-briefing",
  styleUrl: "briefing.scss"
})
export class PyriteTIEBriefing {
  @Prop() public mission?: Mission;
  @State() public time: number = 0;
  @State() public font: FontFile;
  @Element() public dom: HTMLElement;

  protected briefing: Briefing;
  @State() protected timer: any;
  protected events: Event[];
  protected drawMap: TIEDrawMap;
  protected drawObjects: DrawingObject[];

  private ctx: CanvasRenderingContext2D;
  private width: number = 586;
  private height: number = 353;

  public componentDidLoad(): void {
    this.load();
  }

  @Watch("mission")
  public load(): void {
    if (this.mission) {
      this.briefing = this.mission.Briefing;

      const canvas = this.dom.querySelector("canvas");
      if (canvas) {
        const font = "tiny";
        fetch(`/assets/${font}.fnt`)
          .then((res: Response) => res.arrayBuffer())
          .then((value: ArrayBuffer) => {
            this.font = new FontFile(value);
            this.ctx = canvas.getContext("2d");
            this.init();
            this.pause();
            this.tick();
          });
      }
    }
  }

  public render(): JSX.Element {
    return (
      <Host>
        <canvas class="notification is-marginless" width={this.width} height={this.height} />
        <div class="is-centered buttons notification is-primary" style={{ width: `${this.width}px` }}>
          <a class="button is-primary is-small is-inverted" onClick={this.init.bind(this)}>
            <span class="icon">
              <i class="fa fa-undo fa-lg"></i>
            </span>
            <span>Reset</span>
          </a>
          <a class="button is-primary is-small is-inverted" onClick={this.pause.bind(this)}>
            <span class="icon">
              <i class={`fa fa-lg ${this.timer ? "fa-pause" : "fa-play"}`}></i>
            </span>
            <span>{this.timer ? "Pause" : "Play"}</span>
          </a>
          {/* <a class="button is-primary is-small is-inverted" onClick={this.skip.bind(this)}>
            <span class="icon">
              <i class="fa fa-forward fa-lg"></i>
            </span>
            <span>Skip</span>
          </a> */}
        </div>
      </Host>
    );
  }

  private skip(): void {}

  private pause(): void {
    if (this.timer) {
      clearInterval(this.timer); //pause
      this.timer = undefined;
    } else {
      if (this.time === 0) {
        this.init();
      }
      // start
      this.timer = setInterval(this.tick.bind(this), 80);
    }
  }

  private tick(): void {
    this.time = this.time + 1;
    if (!this.events.length && this.timer) {
      clearInterval(this.timer);
    }
    const toProcess: Event[] = this.events.filter((e: Event) => e.Time <= this.time);
    if (toProcess.length) {
      this.processEvents(toProcess);
      this.events = this.events.filter((e: Event) => e.Time > this.time);
    }
    if (this.time >= this.briefing.RunningTime) {
      this.init(); // reset
    }
    this.draw();
  }

  private init(): void {
    this.time = 0;
    this.events = this.briefing.Events.sort((a: Event, b: Event) => a.Time - b.Time);

    this.drawMap = new TIEDrawMap(this.ctx, this.font, this.mission);
    this.drawObjects = [this.drawMap];
    this.draw();
    this.tick();

    if (this.timer) {
      clearInterval(this.timer);
    }
    this.timer = setInterval(this.tick.bind(this), 80);
  }

  private draw(): void {
    for (const drawObject of this.drawObjects) {
      drawObject.draw(this.time);
    }
  }

  private processEvents(events: Event[]): void {
    if (!this.ctx) {
      return;
    }
    for (const event of events) {
      switch (event.EventType) {
        case EventType.TitleText:
        case EventType.CaptionText:
        case EventType.MoveMap:
        case EventType.ZoomMap:
          this.drawMap.processEvent(event);
          break;
        default:
          if (event.EventType >= EventType.FGTag1 && event.EventType <= EventType.FGTag8) {
            this.drawObjects.push(new DrawFGTag(this.drawMap, event));
          } else if (event.EventType >= EventType.TextTag1 && event.EventType <= EventType.TextTag8) {
            this.drawObjects.push(new DrawTextTag(this.drawMap, event));
          } else if (event.EventType === EventType.ClearFGTags) {
            this.drawObjects = this.drawObjects.filter(draw => !(draw instanceof DrawFGTag));
          } else if (event.EventType === EventType.ClearTextTags) {
            this.drawObjects = this.drawObjects.filter(draw => !(draw instanceof DrawTextTag));
          } else {
            console.warn("unhandled event", event);
            // Page Break
          }
      }
    }
  }
}

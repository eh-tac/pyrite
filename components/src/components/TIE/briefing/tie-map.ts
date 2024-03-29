import { Constants, Event, FlightGroup, Mission } from "../../../model/TIE";
import { EventType } from "../../../model/TIE/event";
import { FontFile } from "../../../model/util/font";
import { DrawingObject } from "../../../view-model/drawing-object";

export class TIEDrawMap extends DrawingObject {
  public mapX: number = 0;
  public mapY: number = 0;
  public zoomX: number = 54;
  public zoomY: number = 54;
  public offX: number = 0;
  public offY: number = 0;
  private topH: number = 30;
  private botH: number = 50;
  private width: number;
  private height: number;

  private title: string;
  private caption: string;
  // colours
  private grid: string = "#780000";
  private textBG: string = "#0000aa";

  constructor(
    public ctx: CanvasRenderingContext2D,
    public font: FontFile,
    public mission: Mission,
    public iconBitmap: ImageBitmap,
    public dummyCtx: CanvasRenderingContext2D
  ) {
    super(ctx, font);
    this.width = ctx.canvas.width;
    this.height = ctx.canvas.height;
  }

  public translate(coordinates: number[]): [number, number] {
    const [briefX, briefY] = coordinates;
    const x = Math.round((2 * this.zoomX * briefX) / 256) + this.offX;
    const y = Math.round((2 * this.zoomY * briefY) / 256) + this.offY;
    return [x, y];
  }

  public processEvent(event: Event): void {
    switch (event.EventType) {
      case EventType.TitleText:
        this.title = event.Text;
        break;
      case EventType.CaptionText:
        this.caption = event.Text;
        break;
      case EventType.MoveMap:
        this.mapX = event.Variables[0];
        this.mapY = event.Variables[1];
        break;
      // todo move canvas
      case EventType.ZoomMap:
        this.zoomX = event.Variables[0];
        this.zoomY = event.Variables[1];
        break;
    }
  }

  public draw(tick: number): void {
    this.rect(0, 0, this.width, this.height, "black");

    this.ctx.strokeStyle = this.grid;
    const gap = 100;
    for (let i = gap; i < this.width; i += gap) {
      this.ctx.beginPath();
      this.ctx.moveTo(i, 0);
      this.ctx.lineTo(i, this.height);
      this.ctx.stroke();
    }

    for (let i = gap; i < this.height; i += gap) {
      this.ctx.beginPath();
      this.ctx.moveTo(0, i);
      this.ctx.lineTo(this.width, i);
      this.ctx.stroke();
    }

    this.offX = Math.round((2 * -this.zoomX * this.mapX) / 256 + this.width / 2);
    this.offY = Math.round((2 * -this.zoomY * this.mapY) / 256 + this.height / 2);
    const fgsToDraw = this.mission.FlightGroups.filter(fg => fg.showOnBriefing);
    fgsToDraw.forEach(fg => {
      this.drawFG(fg);
    });

    this.drawEdges();
  }

  public drawEdges(): void {
    this.rect(0, 0, this.width, this.topH, this.textBG);
    this.rect(0, this.height - this.botH, this.width, this.botH, this.textBG);

    if (this.title) {
      this.drawText(this.title, 2, 2);
    }

    if (this.caption) {
      this.drawText(this.caption, 2, this.height - this.botH);
    }
  }

  private drawFG(fg: FlightGroup): void {
    const briefX = fg.briefingCoordinates[0];
    const briefY = fg.briefingCoordinates[1];
    const x = Math.round((2 * this.zoomX * briefX) / 256) + this.offX + 4;
    const y = Math.round((2 * this.zoomY * briefY) / 256) + this.offY + 4;
    const colour = this.getHex(Constants.IFFCOLOR[fg.Iff].toLowerCase());

    const iconPos = fg.CraftType;

    this.dummyCtx.drawImage(this.iconBitmap, iconPos * 16, 0, 16, 16, 0, 0, 16, 16);
    const data = this.dummyCtx.getImageData(0, 0, 16, 16);

    for (let iy = 0; iy < 16; iy++) {
      for (let ix = 0; ix < 16; ix++) {
        const i = (iy * 16 + ix) * 4;
        const [r, g, b, a] = data.data.slice(i, i + 4);
        if (!r && !g && !b) {
          // black
          data.data[i + 3] = 0; // set alpha to 0
        }
      }
    }
    this.dummyCtx.putImageData(data, 0, 0);
    this.ctx.drawImage(this.dummyCtx.canvas, x, y);
  }
}

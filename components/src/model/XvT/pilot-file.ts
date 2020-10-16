import { PilotFileBase } from "./base/pilot-file-base";

export class PilotFile extends PilotFileBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public get LaserLabel(): string {
    return this.shootInfo(this.LasersHit, this.LasersTotal);
  }

  public get LaserPercent(): string {
    return this.percent(this.LasersHit, this.LasersTotal);
  }

  public get WarheadLabel(): string {
    return this.shootInfo(this.WarheadsHit, this.WarheadsTotal);
  }

  public get WarheadPercent(): string {
    return this.percent(this.WarheadsHit, this.WarheadsTotal);
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit} / ${fired}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }
}

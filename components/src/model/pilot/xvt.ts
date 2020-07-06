import { PilotData } from ".";
import { getChar, getInt } from "../hex";
import { XvTTeamStats } from "./xvt-team-stats";

export class XvTPlt implements PilotData {
  public name: string;
  public totalScore: number;
  public kills: number;
  public lasersHit: number;
  public lasersFired: number;
  public warheadsHit: number;
  public warheadsFired: number;
  public craftLosses: number;

  public currentRating: string;

  public teamStats: XvTTeamStats[];

  constructor(hex: ArrayBuffer) {
    const off = 0x0;
    this.name = getChar(hex, off, 12);

    this.totalScore = getInt(hex, 0xe);
    this.kills = getInt(hex, 0x35e);
    this.craftLosses = getInt(hex, 0x146e);
    this.lasersHit = getInt(hex, 0x143e);
    this.lasersFired = getInt(hex, 0x144a);
    this.warheadsHit = getInt(hex, 0x1456);
    this.warheadsFired = getInt(hex, 0x1462);
    this.currentRating = getChar(hex, 0x2392, 32);

    this.teamStats = [new XvTTeamStats("Rebel", hex.slice(0x3ef2)), new XvTTeamStats("Imperial", hex.slice(0x12716))];

    console.log(this, hex);
  }

  public get LaserLabel(): string {
    return this.shootInfo(this.lasersHit, this.lasersFired);
  }

  public get LaserPercent(): string {
    return this.percent(this.lasersHit, this.lasersFired);
  }

  public get WarheadLabel(): string {
    return this.shootInfo(this.warheadsHit, this.warheadsFired);
  }

  public get WarheadPercent(): string {
    return this.percent(this.warheadsHit, this.warheadsFired);
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit} / ${fired}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }
}

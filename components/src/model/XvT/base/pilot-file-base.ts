import { Byteable } from "../../../byteable";
import { Constants, PilotRating } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { TeamStats } from "../team-stats";
import { getChar, getInt, writeChar, writeInt, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PilotFileBase extends PyriteBase implements Byteable {
  public PilotFileLength: number;
  public Name: string;
  public totalScore: number;
  public Kills: number;
  public LasersHit: number;
  public LasersTotal: number;
  public WarheadsHit: number;
  public WarheadsTotal: number;
  public CraftLosses: number;
  public PilotRating: PilotRating;
  public RatingLabel: string;
  public RebelStats: TeamStats;
  public ImperialStats: TeamStats;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Name = getChar(hex, 0x0000, 14);
    this.totalScore = getInt(hex, 0x000e);
    this.Kills = getInt(hex, 0x035e);
    this.LasersHit = getInt(hex, 0x143e);
    this.LasersTotal = getInt(hex, 0x144a);
    this.WarheadsHit = getInt(hex, 0x1456);
    this.WarheadsTotal = getInt(hex, 0x1462);
    this.CraftLosses = getInt(hex, 0x146e);
    this.PilotRating = getInt(hex, 0x2326) as PilotRating;
    this.RatingLabel = getChar(hex, 0x2392, 32);
    this.RebelStats = new TeamStats(hex.slice(0x3ef2), this.TIE);
    offset = 0x3ef2 + this.RebelStats.getLength();
    this.ImperialStats = new TeamStats(hex.slice(0x12716), this.TIE);
    offset = 0x12716 + this.ImperialStats.getLength();
    this.PilotFileLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Name: this.Name,
      totalScore: this.totalScore,
      Kills: this.Kills,
      LasersHit: this.LasersHit,
      LasersTotal: this.LasersTotal,
      WarheadsHit: this.WarheadsHit,
      WarheadsTotal: this.WarheadsTotal,
      CraftLosses: this.CraftLosses,
      PilotRating: this.PilotRatingLabel,
      RatingLabel: this.RatingLabel,
      RebelStats: this.RebelStats.toJSON(),
      ImperialStats: this.ImperialStats.toJSON(),
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeChar(hex, this.Name, 0x0000, 14);
    writeInt(hex, this.totalScore, 0x000e);
    writeInt(hex, this.Kills, 0x035e);
    writeInt(hex, this.LasersHit, 0x143e);
    writeInt(hex, this.LasersTotal, 0x144a);
    writeInt(hex, this.WarheadsHit, 0x1456);
    writeInt(hex, this.WarheadsTotal, 0x1462);
    writeInt(hex, this.CraftLosses, 0x146e);
    writeInt(hex, this.PilotRating, 0x2326);
    writeChar(hex, this.RatingLabel, 0x2392, 32);
    writeObject(hex, this.RebelStats, 0x3ef2);
    writeObject(hex, this.ImperialStats, 0x12716);

    return hex;
  }

  public get PilotRatingLabel(): string {
    return Constants.PILOTRATING[this.PilotRating] || "Unknown";
  }

  public getLength(): number {
    return this.PilotFileLength;
  }
}

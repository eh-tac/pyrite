import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getChar, getInt, writeChar, writeInt } from '@pyrite/core';
export abstract class PLTConnectedPlayerDataBase extends PyriteBase implements Byteable {
  public readonly PLTCONNECTEDPLAYERDATALENGTH: number = 88;
  public pilotLongNameUnused: string;
  public pilotShortName: string;
  public fgIndex: number;
  public DPPlayerID: number;
  public pilotRank: number;
  public playerScore: number;
  public fullKills: number;
  public sharedKills: number;
  public unusedInspections: number;
  public assistKills: number;
  public losses: number;
  public craftType: number;
  public optionalCraftIndex: number;
  public optionalWarhead: number;
  public optionalBeam: number;
  public optionalCountermeasure: number;
  public hasDisconnectedFromHostUNK: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.pilotLongNameUnused = getChar(hex, 0x0000, 14);
    this.pilotShortName = getChar(hex, 0x000e, 14);
    this.fgIndex = getInt(hex, 0x001c);
    this.DPPlayerID = getInt(hex, 0x0020);
    this.pilotRank = getInt(hex, 0x0024);
    this.playerScore = getInt(hex, 0x0028);
    this.fullKills = getInt(hex, 0x002c);
    this.sharedKills = getInt(hex, 0x0030);
    this.unusedInspections = getInt(hex, 0x0034);
    this.assistKills = getInt(hex, 0x0038);
    this.losses = getInt(hex, 0x003c);
    this.craftType = getInt(hex, 0x0040);
    this.optionalCraftIndex = getInt(hex, 0x0044);
    this.optionalWarhead = getInt(hex, 0x0048);
    this.optionalBeam = getInt(hex, 0x004c);
    this.optionalCountermeasure = getInt(hex, 0x0050);
    this.hasDisconnectedFromHostUNK = getInt(hex, 0x0054);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      pilotLongNameUnused: this.pilotLongNameUnused,
      pilotShortName: this.pilotShortName,
      fgIndex: this.fgIndex,
      DPPlayerID: this.DPPlayerID,
      pilotRank: this.pilotRank,
      playerScore: this.playerScore,
      fullKills: this.fullKills,
      sharedKills: this.sharedKills,
      unusedInspections: this.unusedInspections,
      assistKills: this.assistKills,
      losses: this.losses,
      craftType: this.craftType,
      optionalCraftIndex: this.optionalCraftIndex,
      optionalWarhead: this.optionalWarhead,
      optionalBeam: this.optionalBeam,
      optionalCountermeasure: this.optionalCountermeasure,
      hasDisconnectedFromHostUNK: this.hasDisconnectedFromHostUNK
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeChar(hex, this.pilotLongNameUnused, 0x0000, 14);
    writeChar(hex, this.pilotShortName, 0x000e, 14);
    writeInt(hex, this.fgIndex, 0x001c);
    writeInt(hex, this.DPPlayerID, 0x0020);
    writeInt(hex, this.pilotRank, 0x0024);
    writeInt(hex, this.playerScore, 0x0028);
    writeInt(hex, this.fullKills, 0x002c);
    writeInt(hex, this.sharedKills, 0x0030);
    writeInt(hex, this.unusedInspections, 0x0034);
    writeInt(hex, this.assistKills, 0x0038);
    writeInt(hex, this.losses, 0x003c);
    writeInt(hex, this.craftType, 0x0040);
    writeInt(hex, this.optionalCraftIndex, 0x0044);
    writeInt(hex, this.optionalWarhead, 0x0048);
    writeInt(hex, this.optionalBeam, 0x004c);
    writeInt(hex, this.optionalCountermeasure, 0x0050);
    writeInt(hex, this.hasDisconnectedFromHostUNK, 0x0054);

    return hex;
  }

  public getLength(): number {
    return this.PLTCONNECTEDPLAYERDATALENGTH;
  }
}

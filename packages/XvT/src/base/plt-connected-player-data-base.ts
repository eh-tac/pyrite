import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { getChar, getInt, writeChar, writeInt } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

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
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.pilotLongNameUnused = getChar(hex, 0x0000, 14);
    this.pilotShortName = getChar(hex, 0x000E, 14);
    this.fgIndex = getInt(hex, 0x001C);
    this.DPPlayerID = getInt(hex, 0x0020);
    this.pilotRank = getInt(hex, 0x0024);
    this.playerScore = getInt(hex, 0x0028);
    this.fullKills = getInt(hex, 0x002C);
    this.sharedKills = getInt(hex, 0x0030);
    this.unusedInspections = getInt(hex, 0x0034);
    this.assistKills = getInt(hex, 0x0038);
    this.losses = getInt(hex, 0x003C);
    this.craftType = getInt(hex, 0x0040);
    this.optionalCraftIndex = getInt(hex, 0x0044);
    this.optionalWarhead = getInt(hex, 0x0048);
    this.optionalBeam = getInt(hex, 0x004C);
    this.optionalCountermeasure = getInt(hex, 0x0050);
    this.hasDisconnectedFromHostUNK = getInt(hex, 0x0054);
    
  }
  
  public toJSON(): object {
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
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeChar(hex, this.pilotLongNameUnused, 0x0000);
    writeChar(hex, this.pilotShortName, 0x000E);
    writeInt(hex, this.fgIndex, 0x001C);
    writeInt(hex, this.DPPlayerID, 0x0020);
    writeInt(hex, this.pilotRank, 0x0024);
    writeInt(hex, this.playerScore, 0x0028);
    writeInt(hex, this.fullKills, 0x002C);
    writeInt(hex, this.sharedKills, 0x0030);
    writeInt(hex, this.unusedInspections, 0x0034);
    writeInt(hex, this.assistKills, 0x0038);
    writeInt(hex, this.losses, 0x003C);
    writeInt(hex, this.craftType, 0x0040);
    writeInt(hex, this.optionalCraftIndex, 0x0044);
    writeInt(hex, this.optionalWarhead, 0x0048);
    writeInt(hex, this.optionalBeam, 0x004C);
    writeInt(hex, this.optionalCountermeasure, 0x0050);
    writeInt(hex, this.hasDisconnectedFromHostUNK, 0x0054);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTCONNECTEDPLAYERDATALENGTH;
  }
}
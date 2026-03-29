import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { PLTAIRankCountRecord } from "../pltai-rank-count-record";
import { PLTCategoryTypeRecord } from "../plt-category-type-record";
import { PLTPlayerRankCountRecord } from "../plt-player-rank-count-record";
import { getInt, writeInt, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PL2DebriefRecordBase extends PyriteBase implements Byteable {
  public readonly PL2DEBRIEFRECORDLENGTH: number = 5256;
  public UnknownRecord1: PLTCategoryTypeRecord;
  public UnknownRecord2: PLTCategoryTypeRecord;
  public UnknownRecord3: PLTCategoryTypeRecord;
  public enemyKillsEXX: PLTCategoryTypeRecord;
  public friendlyKillsEXX: PLTCategoryTypeRecord;
  public totalKillCountByCraftType: number[];
  public FullKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public SharedKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public AssistKillsOnPlayerRank: PLTPlayerRankCountRecord;
  public FullKillsOnAIRank: PLTAIRankCountRecord;
  public SharedKillsOnAIRank: PLTAIRankCountRecord;
  public AssistKillsOnAIRank: PLTAIRankCountRecord;
  public NumHiddenCargoFoundEXX: PLTCategoryTypeRecord;
  public NumCannonHitsEXX: PLTCategoryTypeRecord;
  public NumCannonFiredEXX: PLTCategoryTypeRecord;
  public NumWarheadHitsEXX: PLTCategoryTypeRecord;
  public NumWarheadFiredEXX: PLTCategoryTypeRecord;
  public NumCraftLossesEXX: PLTCategoryTypeRecord;
  public CraftLossesFromCollisionEXX: PLTCategoryTypeRecord;
  public CraftLossesFromStarshipEXX: PLTCategoryTypeRecord;
  public CraftLossesFromMineEXX: PLTCategoryTypeRecord;
  public LossesFromPlayerRank: PLTPlayerRankCountRecord;
  public LossesFromAIRank: PLTAIRankCountRecord;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.UnknownRecord1 = new PLTCategoryTypeRecord(hex.slice(0x0000), this.TIE);
    this.UnknownRecord2 = new PLTCategoryTypeRecord(hex.slice(0x000C), this.TIE);
    this.UnknownRecord3 = new PLTCategoryTypeRecord(hex.slice(0x0018), this.TIE);
    this.enemyKillsEXX = new PLTCategoryTypeRecord(hex.slice(0x0024), this.TIE);
    this.friendlyKillsEXX = new PLTCategoryTypeRecord(hex.slice(0x0030), this.TIE);
    this.totalKillCountByCraftType = [];
    offset = 0x003C;
    for (let i = 0; i < 900; i++) {
      const t = getInt(hex, offset);
      this.totalKillCountByCraftType.push(t);
      offset += 4;
    }
    this.FullKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0E4C), this.TIE);
    this.SharedKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0F78), this.TIE);
    this.AssistKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x10A4), this.TIE);
    this.FullKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x11D0), this.TIE);
    this.SharedKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x1218), this.TIE);
    this.AssistKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x1260), this.TIE);
    this.NumHiddenCargoFoundEXX = new PLTCategoryTypeRecord(hex.slice(0x12A8), this.TIE);
    this.NumCannonHitsEXX = new PLTCategoryTypeRecord(hex.slice(0x12B4), this.TIE);
    this.NumCannonFiredEXX = new PLTCategoryTypeRecord(hex.slice(0x12C0), this.TIE);
    this.NumWarheadHitsEXX = new PLTCategoryTypeRecord(hex.slice(0x12CC), this.TIE);
    this.NumWarheadFiredEXX = new PLTCategoryTypeRecord(hex.slice(0x12D8), this.TIE);
    this.NumCraftLossesEXX = new PLTCategoryTypeRecord(hex.slice(0x12E4), this.TIE);
    this.CraftLossesFromCollisionEXX = new PLTCategoryTypeRecord(hex.slice(0x12F0), this.TIE);
    this.CraftLossesFromStarshipEXX = new PLTCategoryTypeRecord(hex.slice(0x12FC), this.TIE);
    this.CraftLossesFromMineEXX = new PLTCategoryTypeRecord(hex.slice(0x1308), this.TIE);
    this.LossesFromPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1314), this.TIE);
    this.LossesFromAIRank = new PLTAIRankCountRecord(hex.slice(0x1440), this.TIE);
    
  }
  
  public toJSON(): object {
    return {
      UnknownRecord1: this.UnknownRecord1,
      UnknownRecord2: this.UnknownRecord2,
      UnknownRecord3: this.UnknownRecord3,
      enemyKillsEXX: this.enemyKillsEXX,
      friendlyKillsEXX: this.friendlyKillsEXX,
      totalKillCountByCraftType: this.totalKillCountByCraftType,
      FullKillsOnPlayerRank: this.FullKillsOnPlayerRank,
      SharedKillsOnPlayerRank: this.SharedKillsOnPlayerRank,
      AssistKillsOnPlayerRank: this.AssistKillsOnPlayerRank,
      FullKillsOnAIRank: this.FullKillsOnAIRank,
      SharedKillsOnAIRank: this.SharedKillsOnAIRank,
      AssistKillsOnAIRank: this.AssistKillsOnAIRank,
      NumHiddenCargoFoundEXX: this.NumHiddenCargoFoundEXX,
      NumCannonHitsEXX: this.NumCannonHitsEXX,
      NumCannonFiredEXX: this.NumCannonFiredEXX,
      NumWarheadHitsEXX: this.NumWarheadHitsEXX,
      NumWarheadFiredEXX: this.NumWarheadFiredEXX,
      NumCraftLossesEXX: this.NumCraftLossesEXX,
      CraftLossesFromCollisionEXX: this.CraftLossesFromCollisionEXX,
      CraftLossesFromStarshipEXX: this.CraftLossesFromStarshipEXX,
      CraftLossesFromMineEXX: this.CraftLossesFromMineEXX,
      LossesFromPlayerRank: this.LossesFromPlayerRank,
      LossesFromAIRank: this.LossesFromAIRank
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.UnknownRecord1, 0x0000);
    writeObject(hex, this.UnknownRecord2, 0x000C);
    writeObject(hex, this.UnknownRecord3, 0x0018);
    writeObject(hex, this.enemyKillsEXX, 0x0024);
    writeObject(hex, this.friendlyKillsEXX, 0x0030);
    offset = 0x003C;
    for (let i = 0; i < 900; i++) {
      const t = this.totalKillCountByCraftType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.FullKillsOnPlayerRank, 0x0E4C);
    writeObject(hex, this.SharedKillsOnPlayerRank, 0x0F78);
    writeObject(hex, this.AssistKillsOnPlayerRank, 0x10A4);
    writeObject(hex, this.FullKillsOnAIRank, 0x11D0);
    writeObject(hex, this.SharedKillsOnAIRank, 0x1218);
    writeObject(hex, this.AssistKillsOnAIRank, 0x1260);
    writeObject(hex, this.NumHiddenCargoFoundEXX, 0x12A8);
    writeObject(hex, this.NumCannonHitsEXX, 0x12B4);
    writeObject(hex, this.NumCannonFiredEXX, 0x12C0);
    writeObject(hex, this.NumWarheadHitsEXX, 0x12CC);
    writeObject(hex, this.NumWarheadFiredEXX, 0x12D8);
    writeObject(hex, this.NumCraftLossesEXX, 0x12E4);
    writeObject(hex, this.CraftLossesFromCollisionEXX, 0x12F0);
    writeObject(hex, this.CraftLossesFromStarshipEXX, 0x12FC);
    writeObject(hex, this.CraftLossesFromMineEXX, 0x1308);
    writeObject(hex, this.LossesFromPlayerRank, 0x1314);
    writeObject(hex, this.LossesFromAIRank, 0x1440);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PL2DEBRIEFRECORDLENGTH;
  }
}
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

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.UnknownRecord1 = new PLTCategoryTypeRecord(hex.slice(0x0000), this.TIE);
    this.UnknownRecord2 = new PLTCategoryTypeRecord(hex.slice(0x000c), this.TIE);
    this.UnknownRecord3 = new PLTCategoryTypeRecord(hex.slice(0x0018), this.TIE);
    this.enemyKillsEXX = new PLTCategoryTypeRecord(hex.slice(0x0024), this.TIE);
    this.friendlyKillsEXX = new PLTCategoryTypeRecord(hex.slice(0x0030), this.TIE);
    this.totalKillCountByCraftType = [];
    offset = 0x003c;
    for (let i = 0; i < 900; i++) {
      const t = getInt(hex, offset);
      this.totalKillCountByCraftType.push(t);
      offset += 4;
    }
    this.FullKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0e4c), this.TIE);
    this.SharedKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x0f78), this.TIE);
    this.AssistKillsOnPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x10a4), this.TIE);
    this.FullKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x11d0), this.TIE);
    this.SharedKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x1218), this.TIE);
    this.AssistKillsOnAIRank = new PLTAIRankCountRecord(hex.slice(0x1260), this.TIE);
    this.NumHiddenCargoFoundEXX = new PLTCategoryTypeRecord(hex.slice(0x12a8), this.TIE);
    this.NumCannonHitsEXX = new PLTCategoryTypeRecord(hex.slice(0x12b4), this.TIE);
    this.NumCannonFiredEXX = new PLTCategoryTypeRecord(hex.slice(0x12c0), this.TIE);
    this.NumWarheadHitsEXX = new PLTCategoryTypeRecord(hex.slice(0x12cc), this.TIE);
    this.NumWarheadFiredEXX = new PLTCategoryTypeRecord(hex.slice(0x12d8), this.TIE);
    this.NumCraftLossesEXX = new PLTCategoryTypeRecord(hex.slice(0x12e4), this.TIE);
    this.CraftLossesFromCollisionEXX = new PLTCategoryTypeRecord(hex.slice(0x12f0), this.TIE);
    this.CraftLossesFromStarshipEXX = new PLTCategoryTypeRecord(hex.slice(0x12fc), this.TIE);
    this.CraftLossesFromMineEXX = new PLTCategoryTypeRecord(hex.slice(0x1308), this.TIE);
    this.LossesFromPlayerRank = new PLTPlayerRankCountRecord(hex.slice(0x1314), this.TIE);
    this.LossesFromAIRank = new PLTAIRankCountRecord(hex.slice(0x1440), this.TIE);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      UnknownRecord1: this.UnknownRecord1.toJSON(),
      UnknownRecord2: this.UnknownRecord2.toJSON(),
      UnknownRecord3: this.UnknownRecord3.toJSON(),
      enemyKillsEXX: this.enemyKillsEXX.toJSON(),
      friendlyKillsEXX: this.friendlyKillsEXX.toJSON(),
      totalKillCountByCraftType: this.totalKillCountByCraftType,
      FullKillsOnPlayerRank: this.FullKillsOnPlayerRank.toJSON(),
      SharedKillsOnPlayerRank: this.SharedKillsOnPlayerRank.toJSON(),
      AssistKillsOnPlayerRank: this.AssistKillsOnPlayerRank.toJSON(),
      FullKillsOnAIRank: this.FullKillsOnAIRank.toJSON(),
      SharedKillsOnAIRank: this.SharedKillsOnAIRank.toJSON(),
      AssistKillsOnAIRank: this.AssistKillsOnAIRank.toJSON(),
      NumHiddenCargoFoundEXX: this.NumHiddenCargoFoundEXX.toJSON(),
      NumCannonHitsEXX: this.NumCannonHitsEXX.toJSON(),
      NumCannonFiredEXX: this.NumCannonFiredEXX.toJSON(),
      NumWarheadHitsEXX: this.NumWarheadHitsEXX.toJSON(),
      NumWarheadFiredEXX: this.NumWarheadFiredEXX.toJSON(),
      NumCraftLossesEXX: this.NumCraftLossesEXX.toJSON(),
      CraftLossesFromCollisionEXX: this.CraftLossesFromCollisionEXX.toJSON(),
      CraftLossesFromStarshipEXX: this.CraftLossesFromStarshipEXX.toJSON(),
      CraftLossesFromMineEXX: this.CraftLossesFromMineEXX.toJSON(),
      LossesFromPlayerRank: this.LossesFromPlayerRank.toJSON(),
      LossesFromAIRank: this.LossesFromAIRank.toJSON(),
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.UnknownRecord1, 0x0000);
    writeObject(hex, this.UnknownRecord2, 0x000c);
    writeObject(hex, this.UnknownRecord3, 0x0018);
    writeObject(hex, this.enemyKillsEXX, 0x0024);
    writeObject(hex, this.friendlyKillsEXX, 0x0030);
    offset = 0x003c;
    for (let i = 0; i < this.totalKillCountByCraftType.length; i++) {
      const t = this.totalKillCountByCraftType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    writeObject(hex, this.FullKillsOnPlayerRank, 0x0e4c);
    writeObject(hex, this.SharedKillsOnPlayerRank, 0x0f78);
    writeObject(hex, this.AssistKillsOnPlayerRank, 0x10a4);
    writeObject(hex, this.FullKillsOnAIRank, 0x11d0);
    writeObject(hex, this.SharedKillsOnAIRank, 0x1218);
    writeObject(hex, this.AssistKillsOnAIRank, 0x1260);
    writeObject(hex, this.NumHiddenCargoFoundEXX, 0x12a8);
    writeObject(hex, this.NumCannonHitsEXX, 0x12b4);
    writeObject(hex, this.NumCannonFiredEXX, 0x12c0);
    writeObject(hex, this.NumWarheadHitsEXX, 0x12cc);
    writeObject(hex, this.NumWarheadFiredEXX, 0x12d8);
    writeObject(hex, this.NumCraftLossesEXX, 0x12e4);
    writeObject(hex, this.CraftLossesFromCollisionEXX, 0x12f0);
    writeObject(hex, this.CraftLossesFromStarshipEXX, 0x12fc);
    writeObject(hex, this.CraftLossesFromMineEXX, 0x1308);
    writeObject(hex, this.LossesFromPlayerRank, 0x1314);
    writeObject(hex, this.LossesFromAIRank, 0x1440);

    return hex;
  }

  public getLength(): number {
    return this.PL2DEBRIEFRECORDLENGTH;
  }
}

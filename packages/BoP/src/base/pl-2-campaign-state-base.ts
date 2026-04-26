import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { PL2CampaignProgressState } from "../pl-2-campaign-progress-state";
import { getInt, writeInt, writeObject } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PL2CampaignStateBase extends PyriteBase implements Byteable {
  public readonly PL2CAMPAIGNSTATELENGTH: number = 40;
  public ConfigRandomSeed: number;
  public IsInProgressUNK: number;
  public ConfigGameRandomizeLevel: number;
  public saveState: PL2CampaignProgressState;
  public unknown2: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.ConfigRandomSeed = getInt(hex, 0x0000);
    this.IsInProgressUNK = getInt(hex, 0x0004);
    this.ConfigGameRandomizeLevel = getInt(hex, 0x0008);
    this.saveState = new PL2CampaignProgressState(hex.slice(0x000C), this.TIE);
    this.unknown2 = getInt(hex, 0x0024);
    
  }
  
  public toJSON(): object {
    return {
      ConfigRandomSeed: this.ConfigRandomSeed,
      IsInProgressUNK: this.IsInProgressUNK,
      ConfigGameRandomizeLevel: this.ConfigGameRandomizeLevel,
      saveState: this.saveState,
      unknown2: this.unknown2
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.ConfigRandomSeed, 0x0000);
    writeInt(hex, this.IsInProgressUNK, 0x0004);
    writeInt(hex, this.ConfigGameRandomizeLevel, 0x0008);
    writeObject(hex, this.saveState, 0x000C);
    writeInt(hex, this.unknown2, 0x0024);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PL2CAMPAIGNSTATELENGTH;
  }
}
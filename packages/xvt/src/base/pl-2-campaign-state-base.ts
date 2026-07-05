import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { PL2CampaignProgressState } from '../pl-2-campaign-progress-state';
import { getInt, writeInt, writeObject } from '@pyrite/core';
export abstract class PL2CampaignStateBase extends PyriteBase implements Byteable {
  public readonly PL2CAMPAIGNSTATELENGTH: number = 40;
  public ConfigRandomSeed: number;
  public IsInProgressUNK: number;
  public ConfigGameRandomizeLevel: number;
  public saveState: PL2CampaignProgressState;
  public unknown2: number;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.ConfigRandomSeed = getInt(hex, 0x0000);
    this.IsInProgressUNK = getInt(hex, 0x0004);
    this.ConfigGameRandomizeLevel = getInt(hex, 0x0008);
    this.saveState = new PL2CampaignProgressState(hex.slice(0x000c), this.TIE);
    this.unknown2 = getInt(hex, 0x0024);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      ConfigRandomSeed: this.ConfigRandomSeed,
      IsInProgressUNK: this.IsInProgressUNK,
      ConfigGameRandomizeLevel: this.ConfigGameRandomizeLevel,
      saveState: this.saveState.toJSON(),
      unknown2: this.unknown2
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.ConfigRandomSeed, 0x0000);
    writeInt(hex, this.IsInProgressUNK, 0x0004);
    writeInt(hex, this.ConfigGameRandomizeLevel, 0x0008);
    writeObject(hex, this.saveState, 0x000c);
    writeInt(hex, this.unknown2, 0x0024);

    return hex;
  }

  public getLength(): number {
    return this.PL2CAMPAIGNSTATELENGTH;
  }
}

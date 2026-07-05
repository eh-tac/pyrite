import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { PLTBattleProgressState } from '../plt-battle-progress-state';
import { getInt, writeInt, writeObject } from '@pyrite/core';
export abstract class PLTBattleStateBase extends PyriteBase implements Byteable {
  public readonly PLTBATTLESTATELENGTH: number = 160;
  public ConfigRandomSeed: number;
  public IsInProgressUNK: number;
  public ConfigBattleLength: number;
  public ConfigGameRandomizeLevel: number;
  public saveState: PLTBattleProgressState;
  public unknown2: number;

  constructor(
    public hex: ArrayBuffer,
    public TIE?: IMission
  ) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.ConfigRandomSeed = getInt(hex, 0x0000);
    this.IsInProgressUNK = getInt(hex, 0x0004);
    this.ConfigBattleLength = getInt(hex, 0x0008);
    this.ConfigGameRandomizeLevel = getInt(hex, 0x000c);
    this.saveState = new PLTBattleProgressState(hex.slice(0x0010), this.TIE);
    this.unknown2 = getInt(hex, 0x009c);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      ConfigRandomSeed: this.ConfigRandomSeed,
      IsInProgressUNK: this.IsInProgressUNK,
      ConfigBattleLength: this.ConfigBattleLength,
      ConfigGameRandomizeLevel: this.ConfigGameRandomizeLevel,
      saveState: this.saveState.toJSON(),
      unknown2: this.unknown2
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeInt(hex, this.ConfigRandomSeed, 0x0000);
    writeInt(hex, this.IsInProgressUNK, 0x0004);
    writeInt(hex, this.ConfigBattleLength, 0x0008);
    writeInt(hex, this.ConfigGameRandomizeLevel, 0x000c);
    writeObject(hex, this.saveState, 0x0010);
    writeInt(hex, this.unknown2, 0x009c);

    return hex;
  }

  public getLength(): number {
    return this.PLTBATTLESTATELENGTH;
  }
}

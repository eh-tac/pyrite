import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { PLTBattleProgressState } from "../plt-battle-progress-state";
import { getInt, writeInt, writeObject } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTBattleStateBase extends PyriteBase implements Byteable {
  public readonly PLTBATTLESTATELENGTH: number = 160;
  public ConfigRandomSeed: number;
  public IsInProgressUNK: number;
  public ConfigBattleLength: number;
  public ConfigGameRandomizeLevel: number;
  public saveState: PLTBattleProgressState;
  public unknown2: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.ConfigRandomSeed = getInt(hex, 0x0000);
    this.IsInProgressUNK = getInt(hex, 0x0004);
    this.ConfigBattleLength = getInt(hex, 0x0008);
    this.ConfigGameRandomizeLevel = getInt(hex, 0x000C);
    this.saveState = new PLTBattleProgressState(hex.slice(0x0010), this.TIE);
    this.unknown2 = getInt(hex, 0x009C);
    
  }
  
  public toJSON(): object {
    return {
      ConfigRandomSeed: this.ConfigRandomSeed,
      IsInProgressUNK: this.IsInProgressUNK,
      ConfigBattleLength: this.ConfigBattleLength,
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
    writeInt(hex, this.ConfigBattleLength, 0x0008);
    writeInt(hex, this.ConfigGameRandomizeLevel, 0x000C);
    writeObject(hex, this.saveState, 0x0010);
    writeInt(hex, this.unknown2, 0x009C);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTBATTLESTATELENGTH;
  }
}
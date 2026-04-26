import { Byteable } from "../../../core/src/byteable";
import { IMission, PyriteBase } from "../../../core/src/pyrite-base";
import { getInt, writeInt } from "../../../core/src/hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTTournSPRecordBase extends PyriteBase implements Byteable {
  public readonly PLTTOURNSPRECORDLENGTH: number = 40;
  public unknown0x0: number;
  public totalCountFlown: number;
  public numberOfFinishesAnyUNK: number;
  public numberOfFinishesFirst: number;
  public numberOfFinishesSecond: number;
  public numberOfFinishesThird: number;
  public bestScore: number;
  public bestFinish: number;
  public bestEvaluationMedal: number;
  public bestFinishPointMargin: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.unknown0x0 = getInt(hex, 0x0000);
    this.totalCountFlown = getInt(hex, 0x0004);
    this.numberOfFinishesAnyUNK = getInt(hex, 0x0008);
    this.numberOfFinishesFirst = getInt(hex, 0x000C);
    this.numberOfFinishesSecond = getInt(hex, 0x0010);
    this.numberOfFinishesThird = getInt(hex, 0x0014);
    this.bestScore = getInt(hex, 0x0018);
    this.bestFinish = getInt(hex, 0x001C);
    this.bestEvaluationMedal = getInt(hex, 0x0020);
    this.bestFinishPointMargin = getInt(hex, 0x0024);
    
  }
  
  public toJSON(): object {
    return {
      unknown0x0: this.unknown0x0,
      totalCountFlown: this.totalCountFlown,
      numberOfFinishesAnyUNK: this.numberOfFinishesAnyUNK,
      numberOfFinishesFirst: this.numberOfFinishesFirst,
      numberOfFinishesSecond: this.numberOfFinishesSecond,
      numberOfFinishesThird: this.numberOfFinishesThird,
      bestScore: this.bestScore,
      bestFinish: this.bestFinish,
      bestEvaluationMedal: this.bestEvaluationMedal,
      bestFinishPointMargin: this.bestFinishPointMargin
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeInt(hex, this.unknown0x0, 0x0000);
    writeInt(hex, this.totalCountFlown, 0x0004);
    writeInt(hex, this.numberOfFinishesAnyUNK, 0x0008);
    writeInt(hex, this.numberOfFinishesFirst, 0x000C);
    writeInt(hex, this.numberOfFinishesSecond, 0x0010);
    writeInt(hex, this.numberOfFinishesThird, 0x0014);
    writeInt(hex, this.bestScore, 0x0018);
    writeInt(hex, this.bestFinish, 0x001C);
    writeInt(hex, this.bestEvaluationMedal, 0x0020);
    writeInt(hex, this.bestFinishPointMargin, 0x0024);

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTTOURNSPRECORDLENGTH;
  }
}
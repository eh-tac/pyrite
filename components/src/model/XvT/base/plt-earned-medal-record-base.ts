import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getInt, writeInt } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class PLTEarnedMedalRecordBase extends PyriteBase implements Byteable {
  public readonly PLTEARNEDMEDALRECORDLENGTH: number = 96;
  public meleePlaqueCount: number[];
  public tournamentPlaqueCount: number[];
  public exerciseBadgeCount: number[];
  public battleMedalCount: number[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.meleePlaqueCount = [];
    offset = 0x0000;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.meleePlaqueCount.push(t);
      offset += 4;
    }
    this.tournamentPlaqueCount = [];
    offset = 0x0018;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.tournamentPlaqueCount.push(t);
      offset += 4;
    }
    this.exerciseBadgeCount = [];
    offset = 0x0030;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.exerciseBadgeCount.push(t);
      offset += 4;
    }
    this.battleMedalCount = [];
    offset = 0x0048;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.battleMedalCount.push(t);
      offset += 4;
    }
    
  }
  
  public toJSON(): object {
    return {
      meleePlaqueCount: this.meleePlaqueCount,
      tournamentPlaqueCount: this.tournamentPlaqueCount,
      exerciseBadgeCount: this.exerciseBadgeCount,
      battleMedalCount: this.battleMedalCount
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    offset = 0x0000;
    for (let i = 0; i < 6; i++) {
      const t = this.meleePlaqueCount[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0018;
    for (let i = 0; i < 6; i++) {
      const t = this.tournamentPlaqueCount[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0030;
    for (let i = 0; i < 6; i++) {
      const t = this.exerciseBadgeCount[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0048;
    for (let i = 0; i < 6; i++) {
      const t = this.battleMedalCount[i];
      writeInt(hex, t, offset);
      offset += 4;
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.PLTEARNEDMEDALRECORDLENGTH;
  }
}
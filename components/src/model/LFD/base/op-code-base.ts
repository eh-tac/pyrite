import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, writeByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class OpCodeBase extends PyriteBase implements Byteable {
  public OpCodeLength: number;
  public Value: number;
  public ColorIndex: number[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Value = getByte(hex, 0x00);
    this.ColorIndex = [];
    offset = 0x01;
    for (let i = 0; i < this.ColorCount(); i++) {
      const t = getByte(hex, offset);
      this.ColorIndex.push(t);
      offset += 1;
    }
    this.OpCodeLength = offset;
  }
  
  public toJSON(): object {
    return {
      Value: this.Value,
      ColorIndex: this.ColorIndex
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.Value, 0x00);
    offset = 0x01;
    for (let i = 0; i < this.ColorCount(); i++) {
      const t = this.ColorIndex[i];
      writeByte(hex, t, 0x01);
      offset += 1;
    }

    return hex;
  }
  
  protected abstract ColorCount();
  public getLength(): number {
    return this.OpCodeLength;
  }
}
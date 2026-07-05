import { BattleText } from "../battle-text";
import { Byteable } from "../../../byteable";
import { Delt } from "../delt";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Rmap } from "../rmap";
import { writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TIEBattleBase extends PyriteBase implements Byteable {
  public TIEBattleLength: number;
  public HeaderMap: Rmap;
  public BattleName: BattleText;
  public BattleImage: Delt;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.HeaderMap = new Rmap(hex.slice(0x00), this.TIE);
    offset = 0x00 + this.HeaderMap.getLength();
    this.BattleName = new BattleText(hex.slice(0x30), this.TIE);
    offset = 0x30 + this.BattleName.getLength();
    this.BattleImage = new Delt(hex.slice(offset), this.TIE);
    offset += this.BattleImage.getLength();
    this.TIEBattleLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      HeaderMap: this.HeaderMap.toJSON(),
      BattleName: this.BattleName.toJSON(),
      BattleImage: this.BattleImage.toJSON(),
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.HeaderMap, 0x00);
    writeObject(hex, this.BattleName, 0x30);
    writeObject(hex, this.BattleImage, offset);
    offset += this.BattleImage.getLength();

    return hex;
  }

  public getLength(): number {
    return this.TIEBattleLength;
  }
}

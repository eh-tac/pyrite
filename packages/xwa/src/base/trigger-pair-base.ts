import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { Trigger } from '../trigger';
import { getBool, writeBool, writeObject } from '@pyrite/core';
export abstract class TriggerPairBase extends PyriteBase implements Byteable {
  public readonly TRIGGERPAIRLENGTH: number = 16;
  public Trigger1: Trigger;
  public Trigger2: Trigger;
  public T1OrT2: boolean;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();

    this.Trigger1 = new Trigger(hex.slice(0x00), this.TIE);
    this.Trigger2 = new Trigger(hex.slice(0x06), this.TIE);
    this.T1OrT2 = getBool(hex, 0x0e);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Trigger1: this.Trigger1.toJSON(),
      Trigger2: this.Trigger2.toJSON(),
      T1OrT2: this.T1OrT2
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());

    writeObject(hex, this.Trigger1, 0x00);
    writeObject(hex, this.Trigger2, 0x06);
    writeBool(hex, this.T1OrT2, 0x0e);

    return hex;
  }

  public getLength(): number {
    return this.TRIGGERPAIRLENGTH;
  }
}

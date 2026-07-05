import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { Constants, EventType } from '../constants';
import { getShort, writeShort } from '@pyrite/core';
export abstract class EventBase extends PyriteBase implements Byteable {
  public EventLength: number;
  public Time: number;
  public Type: EventType;
  public Variables: number[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Time = getShort(hex, 0x0);
    this.Type = getShort(hex, 0x2) as EventType;
    this.Variables = [];
    offset = 0x4;
    for (let i = 0; i < this.VariableCount(); i++) {
      const t = getShort(hex, offset);
      this.Variables.push(t);
      offset += 2;
    }
    this.EventLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      Time: this.Time,
      Type: this.TypeLabel,
      Variables: this.Variables
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.Time, 0x0);
    writeShort(hex, this.Type, 0x2);
    offset = 0x4;
    for (let i = 0; i < this.Variables.length; i++) {
      const t = this.Variables[i];
      writeShort(hex, t, offset);
      offset += 2;
    }

    return hex;
  }

  public get TypeLabel(): string {
    return Constants.EVENTTYPE[this.Type] || 'Unknown';
  }
  protected abstract VariableCount(): number;
  public getLength(): number {
    return this.EventLength;
  }
}

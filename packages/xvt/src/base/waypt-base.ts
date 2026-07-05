import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { getShort, writeShort } from '@pyrite/core';
export abstract class WayptBase extends PyriteBase implements Byteable {
  public readonly WAYPTLENGTH: number = 44;
  public StartPoints: number[];
  public Waypoints: number[];
  public Rendezvous: number;
  public Hyperspace: number;
  public Briefings: number[];

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.StartPoints = [];
    offset = 0x00;
    for (let i = 0; i < 4; i++) {
      const t = getShort(hex, offset);
      this.StartPoints.push(t);
      offset += 2;
    }
    this.Waypoints = [];
    offset = 0x08;
    for (let i = 0; i < 8; i++) {
      const t = getShort(hex, offset);
      this.Waypoints.push(t);
      offset += 2;
    }
    this.Rendezvous = getShort(hex, 0x18);
    this.Hyperspace = getShort(hex, 0x1a);
    this.Briefings = [];
    offset = 0x1c;
    for (let i = 0; i < 8; i++) {
      const t = getShort(hex, offset);
      this.Briefings.push(t);
      offset += 2;
    }
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      StartPoints: this.StartPoints,
      Waypoints: this.Waypoints,
      Rendezvous: this.Rendezvous,
      Hyperspace: this.Hyperspace,
      Briefings: this.Briefings
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    offset = 0x00;
    for (let i = 0; i < this.StartPoints.length; i++) {
      const t = this.StartPoints[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    offset = 0x08;
    for (let i = 0; i < this.Waypoints.length; i++) {
      const t = this.Waypoints[i];
      writeShort(hex, t, offset);
      offset += 2;
    }
    writeShort(hex, this.Rendezvous, 0x18);
    writeShort(hex, this.Hyperspace, 0x1a);
    offset = 0x1c;
    for (let i = 0; i < this.Briefings.length; i++) {
      const t = this.Briefings[i];
      writeShort(hex, t, offset);
      offset += 2;
    }

    return hex;
  }

  public getLength(): number {
    return this.WAYPTLENGTH;
  }
}

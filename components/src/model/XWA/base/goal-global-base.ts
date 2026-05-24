import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { TriggerPair } from "../trigger-pair";
import { getBool, getByte, getSByte, getString, writeBool, writeByte, writeObject, writeSByte, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalGlobalBase extends PyriteBase implements Byteable {
  public readonly GOALGLOBALLENGTH: number = 122;
  public Triggers: TriggerPair[]; //(contained Unknown1)
  public Name: string; //(contains Unknown2)
  public Version: number;
  public Triggers12OrTriggers34: boolean;
  public Delay: number; //(was Unknown3)
  public Points: number;
  public PointsPerTrigger: number[]; //(was Unknown4-6)
  public ActiveSquence: number;
  
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.Triggers = [];
    offset = 0x00;
    for (let i = 0; i < 2; i++) {
      const t = new TriggerPair(hex.slice(offset), this.TIE);
      this.Triggers.push(t);
      offset += t.getLength();
    }
    this.Name = getString(hex, 0x20, 16);
    this.Version = getByte(hex, 0x30);
    this.Triggers12OrTriggers34 = getBool(hex, 0x31);
    this.Delay = getByte(hex, 0x32);
    this.Points = getSByte(hex, 0x33);
    this.PointsPerTrigger = [];
    offset = 0x34;
    for (let i = 0; i < 4; i++) {
      const t = getByte(hex, offset);
      this.PointsPerTrigger.push(t);
      offset += 1;
    }
    this.ActiveSquence = getByte(hex, 0x38);
    
  }
  
  public toJSON(): Record<string, unknown> | string {
    return {
      Triggers: this.Triggers.map((t) => t.toJSON()),
      Name: this.Name,
      Version: this.Version,
      Triggers12OrTriggers34: this.Triggers12OrTriggers34,
      Delay: this.Delay,
      Points: this.Points,
      PointsPerTrigger: this.PointsPerTrigger,
      ActiveSquence: this.ActiveSquence,
    };
  }
  
  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    offset = 0x00;
    for (let i = 0; i < this.Triggers.length; i++) {
      const t = this.Triggers[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeString(hex, this.Name, 0x20, 16);
    writeByte(hex, this.Version, 0x30);
    writeBool(hex, this.Triggers12OrTriggers34, 0x31);
    writeByte(hex, this.Delay, 0x32);
    writeSByte(hex, this.Points, 0x33);
    offset = 0x34;
    for (let i = 0; i < this.PointsPerTrigger.length; i++) {
      const t = this.PointsPerTrigger[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeByte(hex, this.ActiveSquence, 0x38);

    return hex;
  }
  
  
  public getLength(): number {
    return this.GOALGLOBALLENGTH;
  }
}
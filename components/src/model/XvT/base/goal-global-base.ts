import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Trigger } from "../trigger";
import { getBool, getSByte, writeBool, writeObject, writeSByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalGlobalBase extends PyriteBase implements Byteable {
  public readonly GOALGLOBALLENGTH: number = 42;
  public TriggerA: Trigger[];
  public Trigger1OrTrigger2: boolean;
  public TriggerB: Trigger[];
  public Trigger2OrTrigger3: boolean;
  public Trigger12OrTrigger34: boolean;
  public Points: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.TriggerA = [];
    offset = 0x00;
    for (let i = 0; i < 2; i++) {
      const t = new Trigger(hex.slice(offset), this.TIE);
      this.TriggerA.push(t);
      offset += t.getLength();
    }
    this.Trigger1OrTrigger2 = getBool(hex, 0x0A);
    this.TriggerB = [];
    offset = 0x0B;
    for (let i = 0; i < 2; i++) {
      const t = new Trigger(hex.slice(offset), this.TIE);
      this.TriggerB.push(t);
      offset += t.getLength();
    }
    this.Trigger2OrTrigger3 = getBool(hex, 0x15);
    this.Trigger12OrTrigger34 = getBool(hex, 0x27);
    this.Points = getSByte(hex, 0x29);
    
  }
  
  public toJSON(): object {
    return {
      TriggerA: this.TriggerA,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2,
      TriggerB: this.TriggerB,
      Trigger2OrTrigger3: this.Trigger2OrTrigger3,
      Trigger12OrTrigger34: this.Trigger12OrTrigger34,
      Points: this.Points
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    offset = 0x00;
    for (let i = 0; i < 2; i++) {
      const t = this.TriggerA[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Trigger1OrTrigger2, 0x0A);
    offset = 0x0B;
    for (let i = 0; i < 2; i++) {
      const t = this.TriggerB[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Trigger2OrTrigger3, 0x15);
    writeBool(hex, this.Trigger12OrTrigger34, 0x27);
    writeSByte(hex, this.Points, 0x29);

    return hex;
  }
  
  
  public getLength(): number {
    return this.GOALGLOBALLENGTH;
  }
}
import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Trigger } from "../trigger";
import { getBool, getByte, getSByte, writeBool, writeByte, writeObject, writeSByte } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class GoalGlobalBase extends PyriteBase implements Byteable {
  public readonly GOALGLOBALLENGTH: number = 122;
  public Trigger1: Trigger;
  public Trigger2: Trigger;
  public Trigger1OrTrigger2: boolean;
  public Unknown1: boolean;
  public Trigger3: Trigger;
  public Trigger4: Trigger;
  public Trigger3OrTrigger4: boolean;
  public Unknown2: boolean;
  public Triggers12OrTriggers34: boolean;
  public Unknown3: number;
  public Points: number;
  public Unknown4: number;
  public Unknown5: number;
  public Unknown6: number;
  public ActiveSquence: number;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Trigger1 = new Trigger(hex.slice(0x0000), this.TIE);
    this.Trigger2 = new Trigger(hex.slice(0x0006), this.TIE);
    this.Trigger1OrTrigger2 = getBool(hex, 0x000E);
    this.Unknown1 = getBool(hex, 0x000F);
    this.Trigger3 = new Trigger(hex.slice(0x0010), this.TIE);
    this.Trigger4 = new Trigger(hex.slice(0x0016), this.TIE);
    this.Trigger3OrTrigger4 = getBool(hex, 0x001E);
    this.Unknown2 = getBool(hex, 0x0027);
    this.Triggers12OrTriggers34 = getBool(hex, 0x0031);
    this.Unknown3 = getByte(hex, 0x0032);
    this.Points = getSByte(hex, 0x0033);
    this.Unknown4 = getByte(hex, 0x0034);
    this.Unknown5 = getByte(hex, 0x0035);
    this.Unknown6 = getByte(hex, 0x0036);
    this.ActiveSquence = getByte(hex, 0x0038);
    
  }
  
  public toJSON(): object {
    return {
      Trigger1: this.Trigger1,
      Trigger2: this.Trigger2,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2,
      Unknown1: this.Unknown1,
      Trigger3: this.Trigger3,
      Trigger4: this.Trigger4,
      Trigger3OrTrigger4: this.Trigger3OrTrigger4,
      Unknown2: this.Unknown2,
      Triggers12OrTriggers34: this.Triggers12OrTriggers34,
      Unknown3: this.Unknown3,
      Points: this.Points,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5,
      Unknown6: this.Unknown6,
      ActiveSquence: this.ActiveSquence
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.Trigger1, 0x0000);
    writeObject(hex, this.Trigger2, 0x0006);
    writeBool(hex, this.Trigger1OrTrigger2, 0x000E);
    writeBool(hex, this.Unknown1, 0x000F);
    writeObject(hex, this.Trigger3, 0x0010);
    writeObject(hex, this.Trigger4, 0x0016);
    writeBool(hex, this.Trigger3OrTrigger4, 0x001E);
    writeBool(hex, this.Unknown2, 0x0027);
    writeBool(hex, this.Triggers12OrTriggers34, 0x0031);
    writeByte(hex, this.Unknown3, 0x0032);
    writeSByte(hex, this.Points, 0x0033);
    writeByte(hex, this.Unknown4, 0x0034);
    writeByte(hex, this.Unknown5, 0x0035);
    writeByte(hex, this.Unknown6, 0x0036);
    writeByte(hex, this.ActiveSquence, 0x0038);

    return hex;
  }
  
  
  public getLength(): number {
    return this.GOALGLOBALLENGTH;
  }
}
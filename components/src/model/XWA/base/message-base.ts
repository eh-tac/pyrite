import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Trigger } from "../trigger";
import { getBool, getByte, getShort, getString, writeBool, writeByte, writeObject, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MessageBase extends PyriteBase implements Byteable {
  public readonly MESSAGELENGTH: number = 162;
  public MessageIndex: number;
  public Message: string;
  public SetToTeam: number[];
  public Trigger1: Trigger;
  public Trigger2: Trigger;
  public Unknown1: number;
  public Trigger1OrTrigger2: boolean;
  public Trigger3: Trigger;
  public Trigger4: Trigger;
  public Trigger3OrTrigger4: boolean;
  public Voice: string;
  public OriginatingFG: number;
  public DelaySeconds: number;
  public Triggers12OrTriggers34: boolean;
  public Color: number;
  public Unknown2: number;
  public Cancel1: Trigger;
  public Cancel2: Trigger;
  public Cancel1OrCancel2: boolean;
  public Unknown3: boolean;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.MessageIndex = getShort(hex, 0x00);
    this.Message = getString(hex, 0x02, 64);
    this.SetToTeam = [];
    offset = 0x52;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.SetToTeam.push(t);
      offset += 1;
    }
    this.Trigger1 = new Trigger(hex.slice(0x5C), this.TIE);
    this.Trigger2 = new Trigger(hex.slice(0x62), this.TIE);
    this.Unknown1 = getByte(hex, 0x68);
    this.Trigger1OrTrigger2 = getBool(hex, 0x6A);
    this.Trigger3 = new Trigger(hex.slice(0x6C), this.TIE);
    this.Trigger4 = new Trigger(hex.slice(0x72), this.TIE);
    this.Trigger3OrTrigger4 = getBool(hex, 0x7A);
    this.Voice = getString(hex, 0x7C, 8);
    this.OriginatingFG = getByte(hex, 0x84);
    this.DelaySeconds = getByte(hex, 0x8C);
    this.Triggers12OrTriggers34 = getBool(hex, 0x8D);
    this.Color = getByte(hex, 0x8E);
    this.Unknown2 = getByte(hex, 0x8F);
    this.Cancel1 = new Trigger(hex.slice(0x90), this.TIE);
    this.Cancel2 = new Trigger(hex.slice(0x96), this.TIE);
    this.Cancel1OrCancel2 = getBool(hex, 0x9E);
    this.Unknown3 = getBool(hex, 0xA0);
    
  }
  
  public toJSON(): object {
    return {
      MessageIndex: this.MessageIndex,
      Message: this.Message,
      SetToTeam: this.SetToTeam,
      Trigger1: this.Trigger1,
      Trigger2: this.Trigger2,
      Unknown1: this.Unknown1,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2,
      Trigger3: this.Trigger3,
      Trigger4: this.Trigger4,
      Trigger3OrTrigger4: this.Trigger3OrTrigger4,
      Voice: this.Voice,
      OriginatingFG: this.OriginatingFG,
      DelaySeconds: this.DelaySeconds,
      Triggers12OrTriggers34: this.Triggers12OrTriggers34,
      Color: this.Color,
      Unknown2: this.Unknown2,
      Cancel1: this.Cancel1,
      Cancel2: this.Cancel2,
      Cancel1OrCancel2: this.Cancel1OrCancel2,
      Unknown3: this.Unknown3
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.MessageIndex, 0x00);
    writeString(hex, this.Message, 0x02);
    offset = 0x52;
    for (let i = 0; i < 10; i++) {
      const t = this.SetToTeam[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    writeObject(hex, this.Trigger1, 0x5C);
    writeObject(hex, this.Trigger2, 0x62);
    writeByte(hex, this.Unknown1, 0x68);
    writeBool(hex, this.Trigger1OrTrigger2, 0x6A);
    writeObject(hex, this.Trigger3, 0x6C);
    writeObject(hex, this.Trigger4, 0x72);
    writeBool(hex, this.Trigger3OrTrigger4, 0x7A);
    writeString(hex, this.Voice, 0x7C);
    writeByte(hex, this.OriginatingFG, 0x84);
    writeByte(hex, this.DelaySeconds, 0x8C);
    writeBool(hex, this.Triggers12OrTriggers34, 0x8D);
    writeByte(hex, this.Color, 0x8E);
    writeByte(hex, this.Unknown2, 0x8F);
    writeObject(hex, this.Cancel1, 0x90);
    writeObject(hex, this.Cancel2, 0x96);
    writeBool(hex, this.Cancel1OrCancel2, 0x9E);
    writeBool(hex, this.Unknown3, 0xA0);

    return hex;
  }
  
  
  public getLength(): number {
    return this.MESSAGELENGTH;
  }
}
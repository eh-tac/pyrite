import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Trigger } from "../trigger";
import { getBool, getByte, getString, writeBool, writeByte, writeObject, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MessageBase extends PyriteBase implements Byteable {
  public readonly MESSAGELENGTH: number = 90;
  public Message: string;
  public Triggers: Trigger[];
  public EditorNote: string;
  public DelaySeconds: number;
  public Trigger1OrTrigger2: boolean;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Message = getString(hex, 0x00);
    this.Triggers = [];
    offset = 0x40;
    for (let i = 0; i < 2; i++) {
      const t = new Trigger(hex.slice(offset), this.TIE);
      this.Triggers.push(t);
      offset += t.getLength();
    }
    this.EditorNote = getString(hex, 0x48);
    this.DelaySeconds = getByte(hex, 0x58);
    this.Trigger1OrTrigger2 = getBool(hex, 0x59);
    
  }
  
  public toJSON(): object {
    return {
      Message: this.Message,
      Triggers: this.Triggers,
      EditorNote: this.EditorNote,
      DelaySeconds: this.DelaySeconds,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeString(hex, this.Message, 0x00);
    offset = 0x40;
    for (let i = 0; i < 2; i++) {
      const t = this.Triggers[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeString(hex, this.EditorNote, 0x48);
    writeByte(hex, this.DelaySeconds, 0x58);
    writeBool(hex, this.Trigger1OrTrigger2, 0x59);

    return hex;
  }
  
  
  public getLength(): number {
    return this.MESSAGELENGTH;
  }
}
import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Trigger } from "../trigger";
import { getBool, getByte, getChar, getShort, getString, writeBool, writeByte, writeChar, writeObject, writeShort, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MessageBase extends PyriteBase implements Byteable {
  public readonly MESSAGELENGTH: number = 116;
  public MessageIndex: number;
  public Message: string;
  public SentToTeams: number[];
  public TriggerA: Trigger[];
  public Trigger1OrTrigger2: boolean;
  public TriggerB: Trigger[];
  public Trigger3OrTrigger4: boolean;
  public EditorNote: string;
  public DelaySeconds: number;
  public Trigger12OrTrigger34: boolean;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.MessageIndex = getShort(hex, 0x00);
    this.Message = getChar(hex, 0x02, 64);
    this.SentToTeams = [];
    offset = 0x42;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.SentToTeams.push(t);
      offset += 1;
    }
    this.TriggerA = [];
    offset = 0x4C;
    for (let i = 0; i < 2; i++) {
      const t = new Trigger(hex.slice(offset), this.TIE);
      this.TriggerA.push(t);
      offset += t.getLength();
    }
    this.Trigger1OrTrigger2 = getBool(hex, 0x56);
    this.TriggerB = [];
    offset = 0x57;
    for (let i = 0; i < 2; i++) {
      const t = new Trigger(hex.slice(offset), this.TIE);
      this.TriggerB.push(t);
      offset += t.getLength();
    }
    this.Trigger3OrTrigger4 = getBool(hex, 0x61);
    this.EditorNote = getString(hex, 0x62, 16);
    this.DelaySeconds = getByte(hex, 0x72);
    this.Trigger12OrTrigger34 = getBool(hex, 0x73);
    
  }
  
  public toJSON(): object {
    return {
      MessageIndex: this.MessageIndex,
      Message: this.Message,
      SentToTeams: this.SentToTeams,
      TriggerA: this.TriggerA,
      Trigger1OrTrigger2: this.Trigger1OrTrigger2,
      TriggerB: this.TriggerB,
      Trigger3OrTrigger4: this.Trigger3OrTrigger4,
      EditorNote: this.EditorNote,
      DelaySeconds: this.DelaySeconds,
      Trigger12OrTrigger34: this.Trigger12OrTrigger34
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeShort(hex, this.MessageIndex, 0x00);
    writeChar(hex, this.Message, 0x02);
    offset = 0x42;
    for (let i = 0; i < 10; i++) {
      const t = this.SentToTeams[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x4C;
    for (let i = 0; i < 2; i++) {
      const t = this.TriggerA[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Trigger1OrTrigger2, 0x56);
    offset = 0x57;
    for (let i = 0; i < 2; i++) {
      const t = this.TriggerB[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeBool(hex, this.Trigger3OrTrigger4, 0x61);
    writeString(hex, this.EditorNote, 0x62);
    writeByte(hex, this.DelaySeconds, 0x72);
    writeBool(hex, this.Trigger12OrTrigger34, 0x73);

    return hex;
  }
  
  
  public getLength(): number {
    return this.MESSAGELENGTH;
  }
}
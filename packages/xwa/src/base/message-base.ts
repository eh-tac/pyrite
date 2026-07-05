import { Byteable, IMission, PyriteBase } from '@pyrite/core';
import { TriggerPair } from '../trigger-pair';
import {
  getBool,
  getByte,
  getInt,
  getShort,
  getString,
  writeBool,
  writeByte,
  writeInt,
  writeObject,
  writeShort,
  writeString
} from '@pyrite/core';
export abstract class MessageBase extends PyriteBase implements Byteable {
  public readonly MESSAGELENGTH: number = 162;
  public MessageIndex: number;
  public Message: string;
  public SentToTeam: number[];
  public Triggers: TriggerPair[]; //(contained Unknown1)
  public Voice: string;
  public OriginatingFG: number;
  public Type: number;
  public Delay: number;
  public Triggers12OrTriggers34: boolean;
  public Color: number;
  public SpeakerHeader: boolean; //(was Unknown2)
  public Special: TriggerPair;
  public SpecialMeaning: number; //(was Unknown3) {Ignore, Stop, Finished, Both}

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.MessageIndex = getShort(hex, 0x00);
    this.Message = getString(hex, 0x02, 80);
    this.SentToTeam = [];
    offset = 0x52;
    for (let i = 0; i < 10; i++) {
      const t = getByte(hex, offset);
      this.SentToTeam.push(t);
      offset += 1;
    }
    this.Triggers = [];
    offset = 0x5c;
    for (let i = 0; i < 2; i++) {
      const t = new TriggerPair(hex.slice(offset), this.TIE);
      this.Triggers.push(t);
      offset += t.getLength();
    }
    this.Voice = getString(hex, 0x7c, 8);
    this.OriginatingFG = getInt(hex, 0x84);
    this.Type = getInt(hex, 0x88);
    this.Delay = getByte(hex, 0x8c);
    this.Triggers12OrTriggers34 = getBool(hex, 0x8d);
    this.Color = getByte(hex, 0x8e);
    this.SpeakerHeader = getBool(hex, 0x8f);
    this.Special = new TriggerPair(hex.slice(0x90), this.TIE);
    this.SpecialMeaning = getByte(hex, 0xa0);
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      MessageIndex: this.MessageIndex,
      Message: this.Message,
      SentToTeam: this.SentToTeam,
      Triggers: this.Triggers.map((t) => t.toJSON()),
      Voice: this.Voice,
      OriginatingFG: this.OriginatingFG,
      Type: this.Type,
      Delay: this.Delay,
      Triggers12OrTriggers34: this.Triggers12OrTriggers34,
      Color: this.Color,
      SpeakerHeader: this.SpeakerHeader,
      Special: this.Special.toJSON(),
      SpecialMeaning: this.SpecialMeaning
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeShort(hex, this.MessageIndex, 0x00);
    writeString(hex, this.Message, 0x02, 80);
    offset = 0x52;
    for (let i = 0; i < this.SentToTeam.length; i++) {
      const t = this.SentToTeam[i];
      writeByte(hex, t, offset);
      offset += 1;
    }
    offset = 0x5c;
    for (let i = 0; i < this.Triggers.length; i++) {
      const t = this.Triggers[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeString(hex, this.Voice, 0x7c, 8);
    writeInt(hex, this.OriginatingFG, 0x84);
    writeInt(hex, this.Type, 0x88);
    writeByte(hex, this.Delay, 0x8c);
    writeBool(hex, this.Triggers12OrTriggers34, 0x8d);
    writeByte(hex, this.Color, 0x8e);
    writeBool(hex, this.SpeakerHeader, 0x8f);
    writeObject(hex, this.Special, 0x90);
    writeByte(hex, this.SpecialMeaning, 0xa0);

    return hex;
  }

  public getLength(): number {
    return this.MESSAGELENGTH;
  }
}

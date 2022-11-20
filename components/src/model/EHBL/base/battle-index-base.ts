import { Byteable } from "../../../byteable";
import { Constants } from "../constants";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { getByte, getChar, getString, writeByte, writeChar, writeString } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BattleIndexBase extends PyriteBase implements Byteable {
  public BattleIndexLength: number;
  public Platform: number;
  public EncryptionOffset: number;
  public Title: string;
  public MissionCount: number;
  public Unknown1: number;
  public MissionFilenames: string[];
  public Unknown2: number;
  public Unknown3: number;
  public Unknown4: number;
  public readonly Reserved1: number = 1;
  public readonly Reserved2: number = 0;
  public Unknown5: number;
  public Unknown6: number;
  public readonly Reserved3: number = 1;
  public readonly Reserved4: number = 0;
  public BattleNumber: number;
  public readonly Reserved5: number = 0;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.Platform = getByte(hex, 0x00);
    this.EncryptionOffset = getByte(hex, 0x01);
    this.Title = getString(hex, 0x02, 50);
    this.MissionCount = getByte(hex, 0x35);
    this.Unknown1 = getByte(hex, 0x36);
    this.MissionFilenames = [];
    offset = 0x37;
    for (let i = 0; i < this.MissionCount; i++) {
      const t = getChar(hex, offset, 21);
      this.MissionFilenames.push(t);
      offset += 21;
    }
    this.Unknown2 = getByte(hex, offset);
    this.Unknown3 = getByte(hex, offset);
    this.Unknown4 = getByte(hex, offset);
    // static prop Reserved1
    offset += 1;
    // static prop Reserved2
    offset += 1;
    this.Unknown5 = getByte(hex, offset);
    this.Unknown6 = getByte(hex, offset);
    // static prop Reserved3
    offset += 1;
    // static prop Reserved4
    offset += 1;
    this.BattleNumber = getByte(hex, offset);
    // static prop Reserved5
    offset += 1;
    this.BattleIndexLength = offset;
  }
  
  public toJSON(): object {
    return {
      Platform: this.PlatformLabel,
      EncryptionOffset: this.EncryptionOffset,
      Title: this.Title,
      MissionCount: this.MissionCount,
      Unknown1: this.Unknown1,
      MissionFilenames: this.MissionFilenames,
      Unknown2: this.Unknown2,
      Unknown3: this.Unknown3,
      Unknown4: this.Unknown4,
      Unknown5: this.Unknown5,
      Unknown6: this.Unknown6,
      BattleNumber: this.BattleNumber
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeByte(hex, this.Platform, 0x00);
    writeByte(hex, this.EncryptionOffset, 0x01);
    writeString(hex, this.Title, 0x02);
    writeByte(hex, this.MissionCount, 0x35);
    writeByte(hex, this.Unknown1, 0x36);
    offset = 0x37;
    for (let i = 0; i < this.MissionCount; i++) {
      const t = this.MissionFilenames[i];
      writeChar(hex, t, offset);
      offset += 21;
    }
    writeByte(hex, this.Unknown2, offset);
    writeByte(hex, this.Unknown3, offset);
    writeByte(hex, this.Unknown4, offset);
    writeByte(hex, 1, offset);
    writeByte(hex, 0, offset);
    writeByte(hex, this.Unknown5, offset);
    writeByte(hex, this.Unknown6, offset);
    writeByte(hex, 1, offset);
    writeByte(hex, 0, offset);
    writeByte(hex, this.BattleNumber, offset);
    writeByte(hex, 0, offset);

    return hex;
  }
  
  public get PlatformLabel(): string {
    return Constants.PLATFORM[this.Platform] || "Unknown";
  }
  
  public getLength(): number {
    return this.BattleIndexLength;
  }
}
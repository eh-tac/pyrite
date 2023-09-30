import { BriefingHeader } from "../briefing-header";
import { Byteable } from "../../../byteable";
import { Coordinate } from "../coordinate";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { Icon } from "../icon";
import { MissionHeader } from "../mission-header";
import { Page } from "../page";
import { String } from "../string";
import { Tag } from "../tag";
import { ViewportSetting } from "../viewport-setting";
import { getByte, getShort, writeByte, writeObject, writeShort } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BriefingBase extends PyriteBase implements Byteable {
  public BriefingLength: number;
  public BriefingHeader: BriefingHeader;
  public CoordinateSet: Coordinate[];
  public IconSet: Icon[];
  public WindowSettingsCount: number;
  public Viewports: ViewportSetting[];
  public PageCount: number;
  public Pages: Page[];
  public MissionHeader: MissionHeader;
  public IconExtraData: number[];
  public Tags: Tag;
  public Strings: String;
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.BriefingHeader = new BriefingHeader(hex.slice(0x00), this.TIE);
    this.CoordinateSet = [];
    offset = 0x6;
    for (let i = 0; i < this.CoordinateCount(); i++) {
      const t = new Coordinate(hex.slice(offset), this.TIE);
      this.CoordinateSet.push(t);
      offset += t.getLength();
    }
    this.IconSet = [];
    offset = offset;
    for (let i = 0; i < this.BriefingHeader.IconCount; i++) {
      const t = new Icon(hex.slice(offset), this.TIE);
      this.IconSet.push(t);
      offset += t.getLength();
    }
    this.WindowSettingsCount = getShort(hex, offset);
    this.Viewports = [];
    offset = offset;
    for (let i = 0; i < this.ViewportCount(); i++) {
      const t = new ViewportSetting(hex.slice(offset), this.TIE);
      this.Viewports.push(t);
      offset += t.getLength();
    }
    this.PageCount = getShort(hex, offset);
    this.Pages = [];
    offset = offset;
    for (let i = 0; i < this.PageCount; i++) {
      const t = new Page(hex.slice(offset), this.TIE);
      this.Pages.push(t);
      offset += t.getLength();
    }
    this.MissionHeader = new MissionHeader(hex.slice(offset), this.TIE);
    this.IconExtraData = [];
    offset = offset;
    for (let i = 0; i < this.BriefingHeader.IconCount; i++) {
      const t = getByte(hex, offset);
      this.IconExtraData.push(t);
      offset += 90;
    }
    this.Tags = new Tag(hex.slice(offset), this.TIE);
    offset += this.Tags.getLength();
    this.Strings = new String(hex.slice(offset), this.TIE);
    offset += this.Strings.getLength();
    this.BriefingLength = offset;
  }
  
  public toJSON(): object {
    return {
      BriefingHeader: this.BriefingHeader,
      CoordinateSet: this.CoordinateSet,
      IconSet: this.IconSet,
      WindowSettingsCount: this.WindowSettingsCount,
      Viewports: this.Viewports,
      PageCount: this.PageCount,
      Pages: this.Pages,
      MissionHeader: this.MissionHeader,
      IconExtraData: this.IconExtraData,
      Tags: this.Tags,
      Strings: this.Strings
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    writeObject(hex, this.BriefingHeader, 0x00);
    offset = 0x6;
    for (let i = 0; i < this.CoordinateCount(); i++) {
      const t = this.CoordinateSet[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = offset;
    for (let i = 0; i < this.BriefingHeader.IconCount; i++) {
      const t = this.IconSet[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeShort(hex, this.WindowSettingsCount, offset);
    offset = offset;
    for (let i = 0; i < this.ViewportCount(); i++) {
      const t = this.Viewports[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeShort(hex, this.PageCount, offset);
    offset = offset;
    for (let i = 0; i < this.PageCount; i++) {
      const t = this.Pages[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeObject(hex, this.MissionHeader, offset);
    offset = offset;
    for (let i = 0; i < this.BriefingHeader.IconCount; i++) {
      const t = this.IconExtraData[i];
      writeByte(hex, t, offset);
      offset += 90;
    }
    writeObject(hex, this.Tags, offset);
    writeObject(hex, this.Strings, offset);

    return hex;
  }
  
  protected abstract CoordinateCount();
  protected abstract ViewportCount();
  public getLength(): number {
    return this.BriefingLength;
  }
}
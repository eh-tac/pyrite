import type { Byteable, IMission} from '@pyrite/core';
import { PyriteBase } from '@pyrite/core';
import { getByte, getShort, writeByte, writeObject, writeShort } from '@pyrite/core';

import { BriefingHeader } from '../briefing-header';
import { Coordinate } from '../coordinate';
import { Icon } from '../icon';
import { MissionHeader } from '../mission-header';
import { Page } from '../page';
import { Tag } from '../tag';
import { ViewportSetting } from '../viewport-setting';
import { XWString } from '../xw-string';
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
  public Strings: XWString;

  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    this.beforeConstruct();
    let offset = 0;

    this.BriefingHeader = new BriefingHeader([...hex], this.TIE);
    this.CoordinateSet = [];
    offset = 0x6;
    for (let i = 0; i < this.CoordinateCount(); i++) {
      const t = new Coordinate(hex.slice(offset), this.TIE);
      this.CoordinateSet.push(t);
      offset += t.getLength();
    }
    this.IconSet = [];
    for (let i = 0; i < this.BriefingHeader.IconCount; i++) {
      const t = new Icon(hex.slice(offset), this.TIE);
      this.IconSet.push(t);
      offset += t.getLength();
    }
    this.WindowSettingsCount = getShort(hex, offset);
    offset += 2;
    this.Viewports = [];
    for (let i = 0; i < this.WindowSettingsCount; i++) {
      const t = new ViewportSetting(hex.slice(offset), this.TIE);
      this.Viewports.push(t);
      offset += t.getLength();
    }
    this.PageCount = getShort(hex, offset);
    offset += 2;
    this.Pages = [];
    for (let i = 0; i < this.PageCount; i++) {
      const t = new Page(hex.slice(offset), this.TIE);
      this.Pages.push(t);
      offset += t.getLength();
    }
    this.MissionHeader = new MissionHeader(hex.slice(offset), this.TIE);
    offset += this.MissionHeader.getLength();
    this.IconExtraData = [];
    for (let i = 0; i < this.BriefingHeader.IconCount; i++) {
      const t = getByte(hex, offset);
      this.IconExtraData.push(t);
      offset += 90;
    }
    this.Tags = new Tag(hex.slice(offset), this.TIE);
    offset += this.Tags.getLength();
    this.Strings = new XWString(hex.slice(offset), this.TIE);
    offset += this.Strings.getLength();
    this.BriefingLength = offset;
  }

  public toJSON(): Record<string, unknown> | string {
    return {
      BriefingHeader: this.BriefingHeader.toJSON(),
      CoordinateSet: this.CoordinateSet.map((t) => t.toJSON()),
      IconSet: this.IconSet.map((t) => t.toJSON()),
      WindowSettingsCount: this.WindowSettingsCount,
      Viewports: this.Viewports.map((t) => t.toJSON()),
      PageCount: this.PageCount,
      Pages: this.Pages.map((t) => t.toJSON()),
      MissionHeader: this.MissionHeader.toJSON(),
      IconExtraData: this.IconExtraData,
      Tags: this.Tags.toJSON(),
      Strings: this.Strings.toJSON()
    };
  }

  public toHexBuffer(): ArrayBuffer {
    const hex: ArrayBuffer = new ArrayBuffer(this.getLength());
    let offset = 0;

    writeObject(hex, this.BriefingHeader, 0x00);
    offset = 0x6;
    for (let i = 0; i < this.CoordinateSet.length; i++) {
      const t = this.CoordinateSet[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    for (let i = 0; i < this.IconSet.length; i++) {
      const t = this.IconSet[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeShort(hex, this.WindowSettingsCount, offset);
    offset += 2;
    for (let i = 0; i < this.Viewports.length; i++) {
      const t = this.Viewports[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeShort(hex, this.PageCount, offset);
    offset += 2;
    for (let i = 0; i < this.Pages.length; i++) {
      const t = this.Pages[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    writeObject(hex, this.MissionHeader, offset);
    offset += this.MissionHeader.getLength();
    for (let i = 0; i < this.IconExtraData.length; i++) {
      const t = this.IconExtraData[i];
      writeByte(hex, t, offset);
      offset += 90;
    }
    writeObject(hex, this.Tags, offset);
    offset += this.Tags.getLength();
    writeObject(hex, this.Strings, offset);
    offset += this.Strings.getLength();

    return hex;
  }

  protected abstract CoordinateCount(): number;
  public getLength(): number {
    return this.BriefingLength;
  }
}

import { BriefingBase } from './base/briefing-base';

export class Briefing extends BriefingBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected CoordinateCount(): number {
    return this.BriefingHeader.CoordinateCount * this.BriefingHeader.IconCount;
  }
  protected ViewportCount(): number {
    return this.WindowSettingsCount;
  }
}

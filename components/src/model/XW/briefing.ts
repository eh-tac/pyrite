import { BriefingBase } from "./base/briefing-base";
    
export class Briefing extends BriefingBase {

  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected CoordinateCount(): number {
    return 0;
  }
  protected ViewportCount(): number {
    return 0;
  }
}

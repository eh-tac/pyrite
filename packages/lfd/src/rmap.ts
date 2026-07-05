import { RmapBase } from './base/rmap-base';

export class Rmap extends RmapBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  protected HeaderCount(): number {
    return 0;
  }
}

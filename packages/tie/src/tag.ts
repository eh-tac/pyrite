import type { IMission } from '@pyrite/core';

import { TagBase } from './base/tag-base';

export class Tag extends TagBase {
  public constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE);
    this.TagLength = this.Length + 2;
  }

  public toString() {
    return this.Text;
  }
}

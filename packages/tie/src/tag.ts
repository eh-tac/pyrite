import type { IMission } from '@pyrite/core';

import { TagBase } from './base/tag-base';

export class Tag extends TagBase {
  public constructor(hex: ArrayBuffer, tie: IMission) {
    super(hex, tie);
    this.TagLength = this.Length + 2;
  }

  public toString() {
    return this.Text;
  }
}

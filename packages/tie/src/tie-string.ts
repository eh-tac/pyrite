import type { IMission } from '@pyrite/core';

import { TIEStringBase } from './base/tie-string-base';

export class TIEString extends TIEStringBase {
  public constructor(hex: ArrayBuffer, tie: IMission) {
    super(hex, tie);
    this.TIEStringLength = this.Length + 2;
  }

  public toString() {
    return this.Text;
  }
}

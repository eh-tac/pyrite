import { IMission } from '@pyrite/core';
import { TriggerBase } from './base/trigger-base';
import { Mission } from './mission';

export class Trigger extends TriggerBase {
  public mission: Mission;
  public constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE);
    this.mission = TIE as Mission;
  }

  public toString(): string {
    if (this.Condition === 0) {
      return 'Always';
    }

    const parts = [this.TriggerAmountLabel, 'of', this.VariableTypeLabel];
    if (this.VariableType === 1) {
      const fg = this.mission.getFlightGroup(this.Variable);
      parts.push(fg + '');
    }
    parts.push('must', this.ConditionLabel);

    return parts.join(' ');
  }
}

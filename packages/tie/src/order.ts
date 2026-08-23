import { OrderBase } from './base/order-base';
import { Constants } from './constants';
import type { IMission } from '@pyrite/core';
import { Mission } from './mission';

export class Order extends OrderBase {
  public mission: Mission;
  public constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE);
    this.mission = TIE as Mission;
  }

  public get isSet(): boolean {
    return !!this.Order;
  }

  public toString() {
    const msg = [this.OrderLabel];
    if (this.Target1) {
      const t1 = this.lookup(this.Target1Type, this.Target1);
      msg.push(`${this.Target1TypeLabel} ${this.Target1} ${t1}`);
      if (this.Target2) {
        if (this.Target1OrTarget2) {
          msg.push('OR');
        }
        const t2 = this.lookup(this.Target2Type, this.Target2);
        msg.push(`${this.Target2TypeLabel} ${this.Target2} ${t2}`);
      }
    }
    if (this.Target3) {
      msg.push('THEN');
      const t3 = this.lookup(this.Target3Type, this.Target3);
      msg.push(`${this.Target3TypeLabel} ${this.Target3} ${t3}`);
      if (this.Target2) {
        if (this.Target3OrTarget4) {
          msg.push('OR');
        }
        const t4 = this.lookup(this.Target4Type, this.Target4);
        msg.push(`${this.Target4TypeLabel} ${this.Target4} ${t4}`);
      }
    }

    return msg.join(' ');
  }

  private lookup(type: number, instance: number): string {
    switch (type) {
      case 0: {
        return 'None';
      }
      case 1: {
        return this.mission.getFlightGroup(instance).toString();
      }
      case 2: {
        return Constants.CRAFTTYPE[instance as keyof typeof Constants.CRAFTTYPE];
      }
      case 3: {
        return Constants.CRAFTCATEGORY[instance as keyof typeof Constants.CRAFTCATEGORY];
      }
      case 4: {
        return Constants.OBJECTCATEGORY[instance as keyof typeof Constants.OBJECTCATEGORY];
      }
      case 5: {
        return this.mission.getIFF(instance);
      }
      case 6: {
        return Constants.ORDER[instance as keyof typeof Constants.ORDER];
      }
      case 7: {
        return Constants.CRAFTWHEN[instance as keyof typeof Constants.CRAFTWHEN];
      }
      case 8: {
        const fgs = this.mission.getGlobalGroup(instance);
        return fgs.map((fg) => fg.toString()).join(', ');
      }
      case 9: {
        return Constants.MISC[instance as keyof typeof Constants.MISC];
      }
    }
    return 'Unknown';
  }
}

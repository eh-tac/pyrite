import { Accuracy, accuracy, Percent, percent } from '@pyrite/core';
import { PilotFileBase } from './base/pilot-file-base';

export class PilotFile extends PilotFileBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return '';
  }

  public get TotalScore(): number {
    return this.totalScore;
  }

  public get LaserLabel(): Accuracy {
    return accuracy(this.LasersHit, this.LasersTotal);
  }

  public get LaserPercent(): Percent {
    return percent(this.LasersHit, this.LasersTotal);
  }

  public get WarheadLabel(): Accuracy {
    return accuracy(this.WarheadsHit, this.WarheadsTotal);
  }

  public get WarheadPercent(): Percent {
    return percent(this.WarheadsHit, this.WarheadsTotal);
  }
}

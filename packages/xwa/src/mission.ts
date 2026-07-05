import type { IFlightGroup, IMission } from '@pyrite/core';

import { MissionBase } from './base/mission-base';

export class Mission extends MissionBase implements IMission {
  public beforeConstruct(): void {
    this.TIE = this;
  }

  public getFlightGroup(idx: number): IFlightGroup {
    return this.FlightGroups[idx];
  }

  public getGlobalGroup(idx: number): IFlightGroup[] {
    return this.FlightGroups.filter((fg) => fg.GlobalGroup === idx);
  }

  public getIFF(idx: number): string {
    const lookup = ['Rebel', 'Imperial', ...this.FileHeader.IffNames];
    return lookup[idx] || `UnknownIFF${idx}`;
  }

  public toString(): string {
    return this.Messages.filter((m) => m.isActive)
      .map((m) => m.toString())
      .join('\n');
  }

  protected FGGoalStringCount(): number {
    // The array structure is 3 strings per goal, 8 goals per FG.
    // Incomplete, Complete and Failed in that order.
    return this.FileHeader.NumFGs * 8 * 3;
  }
}

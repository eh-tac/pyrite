import type { IFGScore, IFlightGroup } from '@pyrite/core';

import { Constants } from '.';
import { FlightGroupBase } from './base/flight-group-base';
import type { CraftAbbr } from './constants';
import { ArrivalDifficulty } from './constants';

export class FlightGroup extends FlightGroupBase implements IFlightGroup, IFGScore {
  public beforeConstruct(): void {}

  public get label(): string {
    return this.toString();
  }

  public get isPlayer(): boolean {
    return this.PlayerNumber !== 0;
  }

  public get CraftTypeAbbr(): string {
    return (
      Constants.CRAFTABBR[this.CraftType as unknown as CraftAbbr] ||
      `UnknownCraftType${this.CraftType}`
    );
  }

  public toString(): string {
    return `${this.CraftTypeAbbr} ${this.Name}`;
  }

  public isInDifficultyLevel(level: 'Easy' | 'Medium' | 'Hard'): boolean {
    switch (this.ArrivalDifficulty) {
      case ArrivalDifficulty.all: {
        return true;
      }
      case ArrivalDifficulty.easy: {
        return level === 'Easy';
      }
      case ArrivalDifficulty.medium: {
        return level === 'Medium';
      }
      case ArrivalDifficulty.hard: {
        return level === 'Hard';
      }
      case ArrivalDifficulty.greaterThanEasy: {
        return level === 'Medium' || level === 'Hard';
      }
      case ArrivalDifficulty.lessThanHard: {
        return level === 'Easy' || level === 'Medium';
      }
      default: {
        return false;
      }
    }
  }

  public pointValue(level: 'Easy' | 'Medium' | 'Hard'): number {
    // TODO Implement the logic to return the point value for the specified difficulty level
    return level === 'Medium' ? 0 : 0;
  }
}

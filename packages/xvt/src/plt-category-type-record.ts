import { PLTCategoryTypeRecordBase } from './base/plt-category-type-record-base';
import { TriStat } from './team-stats';

export class PLTCategoryTypeRecord extends PLTCategoryTypeRecordBase implements TriStat {
  public beforeConstruct(): void {}
  public Label: string = '';

  public toString(): string {
    return '';
  }

  public get Exercise(): number {
    return this.exercise;
  }

  public get Melee(): number {
    return this.melee;
  }

  public get Combat(): number {
    return this.combat;
  }
}

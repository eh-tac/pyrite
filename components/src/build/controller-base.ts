import { PyriteBase } from "./pyrite-base";

export interface FieldAttr {
  name: string;
  type: string;
  value?: any;
  options?: object;
}

export class ControllerBase {
  public readonly fields: object;
  constructor(public model: PyriteBase) {}

  public getProps(field: string): object {
    const value = this.model[field];

    return { ...this.fields[field], value };
  }
}

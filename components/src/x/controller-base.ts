import { PyriteBase } from "./pyrite-base";

export interface FieldAttr {
  name: string;
  type: string;
  value?: any;
  options?: { [key: number]: string };
  model?: PyriteBase;
  label?: string;
}

export class ControllerBase {
  public readonly fields: object;
  constructor(public model: PyriteBase) {}

  public getProps(field: string): FieldAttr {
    const model = this.model;
    const value = model[field];

    return { ...this.fields[field], value, model };
  }
}

import { PyriteBase } from "./pyrite-base";

export interface FieldAttr {
  name: string;
  type: string;
  value?: any;
  options?: { [key: number]: string };
  model?: PyriteBase;
  label?: string;
  componentTag?: string;
  componentProp?: string;
}

export class ControllerBase {
  public readonly fields: object;
  constructor(public model: PyriteBase) {}

  public getProps(field: string, value?: any): FieldAttr {
    const model = this.model;
    value = value || model[field];

    return { ...this.fields[field], value, model };
  }
}

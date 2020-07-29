import { Prop, PropObject } from "./prop";

export class TypeScriptPropWriter {
  public constructor(private base: Prop, public functionStubs: string[]) {}

  public get typeLength(): string {
    return this.base.isArray ? "t.getLength()" : `this.${this.base.name}.getLength()`;
  }

  public get hexImports(): string[] {
    return [this.base.hexGetter, this.base.hexSetter].filter(s => !!s);
  }

  public get offsetExpr(): string {
    return this.base.previousValueOffset || this.base.isArray ? "offset" : this.base.offset;
  }

  public getGetter(): string {
    if (this.base instanceof PropObject) {
      return `new ${this.base.structName}(hex.slice(${this.offsetExpr}), this.TIE)`;
    }

    return `${this.base.hexGetter}`;
  }

  public getSetter(propOverride?: string): string {
    const p = propOverride || `this.${this.base.name}`;
    return `${this.base.hexSetter}(hex, ${p}, ${this.offsetExpr})`;
  }
}

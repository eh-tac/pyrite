import { Prop } from "./prop";

export class Struct {
  public size: number = 0;
  public props: { [key: string]: Prop } = {};
  public functionStubs: string[] = [];
  constructor(public name: string, hexSize: string) {
    this.size = parseInt(hexSize, 16);
  }

  public get isVariableLength(): boolean {
    return this.size === 0;
  }

  public addProp(prop: Prop): void {
    this.props[prop.name] = prop;
    this.functionStubs.concat(prop.getFunctionStubs());
  }

  public getProps(): Prop[] {
    return Object.values(this.props);
  }
}

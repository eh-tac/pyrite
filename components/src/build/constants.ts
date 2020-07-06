export class Constants {
  public values: [number, string][] = [];
  constructor(public name: string) {}

  public add(value: string, label: string) {
    this.values.push([parseInt(value, 16), label]);
  }
}

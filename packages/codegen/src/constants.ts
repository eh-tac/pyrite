export class Constants {
  public values: [number, string][] = [];
  constructor(public name: string) {}

  public add(value: string, label: string) {
    const num = Number.parseInt(value, 16);
    if (Number.isNaN(num)) {
      return; // not a value constant, some fluff from the file
    }
    this.values.push([num, label]);
  }
}

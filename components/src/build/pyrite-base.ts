export interface IMission {
  FlightGroups: IFlightGroup[];
  getFlightGroup(idx: number): IFlightGroup;
  getGlobalGroup(idx: number): IFlightGroup[];
  getIFF(idx: number): string;
}

export interface IFlightGroup {
  label: string;
}

export enum DataType {
  char,
  SELECT
}

export interface FieldProp {
  type: DataType;
  value: any;
  options?: { [key: number]: string };
}

export interface IFielder {
  field(name: string): FieldProp;
}

export abstract class PyriteBase {
  public constructor(public hex: ArrayBuffer, public TIE: IMission) {}

  // public compareHex(other: string): boolean {
  //   return this.hex === other;
  // }

  protected beforeConstruct() {}
}

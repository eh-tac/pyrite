export interface IMission {
    FlightGroups: IFlightGroup[];
    getFlightGroup(idx: number): IFlightGroup;
    getGlobalGroup(idx: number): IFlightGroup[];
    getIFF(idx: number): string;
}
export interface IFlightGroup {
    label: string;
}
export declare enum DataType {
    char = 0,
    SELECT = 1
}
export interface FieldProp {
    type: DataType;
    value: any;
    options?: {
        [key: number]: string;
    };
}
export interface IFielder {
    field(name: string): FieldProp;
}
export declare abstract class PyriteBase {
    hex: ArrayBuffer;
    TIE: IMission;
    constructor(hex: ArrayBuffer, TIE: IMission);
    protected beforeConstruct(): void;
}

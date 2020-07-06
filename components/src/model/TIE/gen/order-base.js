import { Constants } from "../constants";
import { getBool, getByte, writeBool, writeByte } from "../../hex";
import { PyriteBase } from "../../pyrite-base";
// tslint:disable member-ordering
// tslint:disable prefer-const
export class OrderBase extends PyriteBase {
    constructor(hex, tie) {
        super(hex, tie);
        this.beforeConstruct();
        let offset = 0;
        this.Order = getByte(hex, 0x00);
        this.Throttle = getByte(hex, 0x01);
        this.Variable1 = getByte(hex, 0x02);
        this.Variable2 = getByte(hex, 0x03);
        this.Unknown18 = getByte(hex, 0x04);
        this.Target3Type = getByte(hex, 0x06);
        this.Target4Type = getByte(hex, 0x07);
        this.Target3 = getByte(hex, 0x08);
        this.Target4 = getByte(hex, 0x09);
        this.Target3OrTarget4 = getBool(hex, 0x0A);
        this.Target1Type = getByte(hex, 0x0C);
        this.Target1 = getByte(hex, 0x0D);
        this.Target2Type = getByte(hex, 0x0E);
        this.Target2 = getByte(hex, 0x0F);
        this.Target1OrTarget2 = getBool(hex, 0x10);
        this.afterConstruct();
    }
    toJSON() {
        return {
            Order: this.OrderLabel,
            Throttle: this.Throttle,
            Variable1: this.Variable1,
            Variable2: this.Variable2,
            Unknown18: this.Unknown18,
            Target3Type: this.Target3TypeLabel,
            Target4Type: this.Target4TypeLabel,
            Target3: this.Target3,
            Target4: this.Target4,
            Target3OrTarget4: this.Target3OrTarget4,
            Target1Type: this.Target1TypeLabel,
            Target1: this.Target1,
            Target2Type: this.Target2TypeLabel,
            Target2: this.Target2,
            Target1OrTarget2: this.Target1OrTarget2
        };
    }
    get OrderLabel() {
        return Constants.ORDER[this.Order] || "Unknown";
    }
    get Target3TypeLabel() {
        return Constants.VARIABLETYPE[this.Target3Type] || "Unknown";
    }
    get Target4TypeLabel() {
        return Constants.VARIABLETYPE[this.Target4Type] || "Unknown";
    }
    get Target1TypeLabel() {
        return Constants.VARIABLETYPE[this.Target1Type] || "Unknown";
    }
    get Target2TypeLabel() {
        return Constants.VARIABLETYPE[this.Target2Type] || "Unknown";
    }
    toHexString() {
        const hex = "";
        let offset = 0;
        writeByte(hex, this.Order, 0x00);
        writeByte(hex, this.Throttle, 0x01);
        writeByte(hex, this.Variable1, 0x02);
        writeByte(hex, this.Variable2, 0x03);
        writeByte(hex, this.Unknown18, 0x04);
        writeByte(hex, this.Target3Type, 0x06);
        writeByte(hex, this.Target4Type, 0x07);
        writeByte(hex, this.Target3, 0x08);
        writeByte(hex, this.Target4, 0x09);
        writeBool(hex, this.Target3OrTarget4, 0x0A);
        writeByte(hex, this.Target1Type, 0x0C);
        writeByte(hex, this.Target1, 0x0D);
        writeByte(hex, this.Target2Type, 0x0E);
        writeByte(hex, this.Target2, 0x0F);
        writeBool(hex, this.Target1OrTarget2, 0x10);
        return hex;
    }
    getLength() {
        return OrderBase.ORDER_LENGTH;
    }
}
OrderBase.ORDER_LENGTH = 0x12;

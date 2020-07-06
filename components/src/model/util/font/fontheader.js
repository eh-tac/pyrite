import { getByte, getUInt, getUShort } from "../../hex";
export class FontHeader {
    constructor(hex) {
        this.w = getUShort(hex, 0);
        this.h = getUShort(hex, 0x2);
        this.flags = getUShort(hex, 0x4);
        this.baseline = getUShort(hex, 0x6);
        this.minChar = getByte(hex, 0x8);
        this.maxChar = getByte(hex, 0x9);
        this.byteWidth = getUShort(hex, 10);
        this.dataOffset = getUInt(hex, 12);
        this.chars = getUInt(hex, 16);
        this.widths = getUInt(hex, 20);
        this.kernData = getUInt(hex, 24);
    }
}

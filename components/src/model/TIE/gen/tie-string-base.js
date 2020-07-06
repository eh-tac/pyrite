import { getChar, getShort, writeChar, writeShort } from "../../hex";
import { PyriteBase } from "../../pyrite-base";
// tslint:disable member-ordering
// tslint:disable prefer-const
export class TIEStringBase extends PyriteBase {
    constructor(hex, tie) {
        super(hex, tie);
        this.TIEStringLength = 0;
        this.beforeConstruct();
        let offset = 0;
        this.Length = getShort(hex, 0x0);
        if (this.Length === 0) {
            this.afterConstruct();
            return;
        }
        this.Text = getChar(hex, 0x2, this.Length);
        this.TIEStringLength = offset;
        this.afterConstruct();
    }
    toJSON() {
        return {
            Length: this.Length,
            Text: this.Text
        };
    }
    toHexString() {
        const hex = "";
        let offset = 0;
        writeShort(hex, this.Length, 0x0);
        if (this.Length === 0) {
            return;
        }
        writeChar(hex, this.Text, 0x2, this.Length);
        return hex;
    }
    getLength() {
        return this.TIEStringLength;
    }
}

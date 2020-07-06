import { Constants } from "../constants";
import { getShort, writeShort } from "../../hex";
import { PyriteBase } from "../../pyrite-base";
// tslint:disable member-ordering
// tslint:disable prefer-const
export class EventBase extends PyriteBase {
    constructor(hex, tie) {
        super(hex, tie);
        this.EventLength = 0;
        this.beforeConstruct();
        let offset = 0;
        this.Time = getShort(hex, 0x0);
        this.EventType = getShort(hex, 0x2);
        this.Variables = [];
        offset = 0x4;
        for (let i = 0; i < this.VariableCount(); i++) {
            const t = getShort(hex, offset);
            this.Variables.push(t);
            offset += 2;
        }
        this.EventLength = offset;
        this.afterConstruct();
    }
    toJSON() {
        return {
            Time: this.Time,
            EventType: this.EventTypeLabel,
            Variables: this.Variables
        };
    }
    get EventTypeLabel() {
        return Constants.EVENTTYPE[this.EventType] || "Unknown";
    }
    toHexString() {
        const hex = "";
        let offset = 0;
        writeShort(hex, this.Time, 0x0);
        writeShort(hex, this.EventType, 0x2);
        offset = 0x4;
        for (let i = 0; i < this.VariableCount(); i++) {
            const t = this.Variables[i];
            writeShort(hex, this.Variables[i], offset);
            offset += 2;
        }
        return hex;
    }
    getLength() {
        return this.EventLength;
    }
}

import { Constants } from "../constants";
import { getByte, writeByte } from "../../hex";
import { PyriteBase } from "../../pyrite-base";
// tslint:disable member-ordering
// tslint:disable prefer-const
export class TriggerBase extends PyriteBase {
    constructor(hex, tie) {
        super(hex, tie);
        this.beforeConstruct();
        let offset = 0;
        this.Condition = getByte(hex, 0x0);
        this.VariableType = getByte(hex, 0x1);
        this.Variable = getByte(hex, 0x2);
        this.TriggerAmount = getByte(hex, 0x3);
        this.afterConstruct();
    }
    toJSON() {
        return {
            Condition: this.ConditionLabel,
            VariableType: this.VariableTypeLabel,
            Variable: this.Variable,
            TriggerAmount: this.TriggerAmountLabel
        };
    }
    get ConditionLabel() {
        return Constants.CONDITION[this.Condition] || "Unknown";
    }
    get VariableTypeLabel() {
        return Constants.VARIABLETYPE[this.VariableType] || "Unknown";
    }
    get TriggerAmountLabel() {
        return Constants.TRIGGERAMOUNT[this.TriggerAmount] || "Unknown";
    }
    toHexString() {
        const hex = "";
        let offset = 0;
        writeByte(hex, this.Condition, 0x0);
        writeByte(hex, this.VariableType, 0x1);
        writeByte(hex, this.Variable, 0x2);
        writeByte(hex, this.TriggerAmount, 0x3);
        return hex;
    }
    getLength() {
        return TriggerBase.TRIGGER_LENGTH;
    }
}
TriggerBase.TRIGGER_LENGTH = 0x4;

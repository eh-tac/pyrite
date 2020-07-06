import { Constants } from "../constants";
import { getByte, writeByte } from "../../hex";
import { PyriteBase } from "../../pyrite-base";
// tslint:disable member-ordering
// tslint:disable prefer-const
export class GoalFGBase extends PyriteBase {
    constructor(hex, tie) {
        super(hex, tie);
        this.beforeConstruct();
        let offset = 0;
        this.Condition = getByte(hex, 0x0);
        this.GoalAmount = getByte(hex, 0x1);
        this.afterConstruct();
    }
    toJSON() {
        return {
            Condition: this.ConditionLabel,
            GoalAmount: this.GoalAmountLabel
        };
    }
    get ConditionLabel() {
        return Constants.CONDITION[this.Condition] || "Unknown";
    }
    get GoalAmountLabel() {
        return Constants.GOALAMOUNT[this.GoalAmount] || "Unknown";
    }
    toHexString() {
        const hex = "";
        let offset = 0;
        writeByte(hex, this.Condition, 0x0);
        writeByte(hex, this.GoalAmount, 0x1);
        return hex;
    }
    getLength() {
        return GoalFGBase.GOALFG_LENGTH;
    }
}
GoalFGBase.GOALFG_LENGTH = 0x2;

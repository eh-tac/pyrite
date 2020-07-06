import { GoalFGBase } from "./gen/goal-fg-base";
export class GoalFG extends GoalFGBase {
    toString() {
        return `${this.ConditionLabel} ${this.GoalAmountLabel}`;
    }
    goalText(fgLabel, count) {
        const amount = count === 1 && this.GoalAmount === 0 ? "" : `${this.GoalAmountLabel} of `;
        return `${amount}${fgLabel} must be ${this.ConditionLabel.toLowerCase()}`;
    }
    get isSet() {
        return this.Condition !== 0 && this.Condition !== 10;
    }
    get isCaptureGoal() {
        return this.Condition === 4; // TODO enum lookup
    }
    captureCount(fgCount) {
        if (!this.isCaptureGoal) {
            return 0;
        }
        switch (this.GoalAmount) {
            case 0: // 100%
                return fgCount;
            case 1: // 50%
                return Math.round(fgCount * 0.5);
            case 2: // at least one
            case 4: // special craft
                return 1;
            case 3: // all but one
                return fgCount - 1;
        }
        return 0;
    }
    get isInvincibleGoal() {
        return [4, 9, 12, 13].includes(this.Condition);
    }
}

import { FlightGroupBase } from "./gen/flight-group-base";
import { Difficulty } from "./mission";
import { Craft } from "./craft";
import { Constants } from "./constants";
export class FlightGroup extends FlightGroupBase {
    get label() {
        return this.toString();
    }
    get summary() {
        return `${this.count} ${this.label} [${this.GroupAILabel}]`;
    }
    get hasMothership() {
        return this.ArriveViaMothership || this.AlternateArriveViaMothership;
    }
    get mothershipFG() {
        const ms = [];
        if (this.ArriveViaMothership) {
            ms.push(this.TIE.getFlightGroup(this.ArrivalMothership));
        }
        if (this.AlternateArriveViaMothership) {
            ms.push(this.TIE.getFlightGroup(this.AlternateArrivalMothership));
        }
        return ms;
    }
    get hasMultipleWaves() {
        return this.NumberOfWaves > 0;
    }
    get IFFLabel() {
        return this.TIE.getIFF(this.Iff);
    }
    get showOnBriefing() {
        const enabled = this.Waypoints[3];
        return !!enabled.Briefing;
    }
    get startCoordinates() {
        return this.Waypoints.map((w) => (w.StartPoints[0] * 1.6) / 1000);
    }
    get hyperCoordinates() {
        return this.Waypoints.map((w) => (w.Hyperspace * 1.6) / 1000);
    }
    get briefingCoordinates() {
        return this.Waypoints.map((w) => w.Briefing);
    }
    get CraftTypeAbbr() {
        return Constants.CRAFTABBR[this.CraftType];
    }
    toString() {
        return `${this.CraftTypeAbbr} ${this.Name}`;
    }
    pointValue(difficulty) {
        if (this.isFriendly) {
            return -10000;
        }
        let diffMult = 1;
        if (difficulty === Difficulty.Easy)
            diffMult = 0.75;
        else if (difficulty === Difficulty.Hard)
            diffMult = 1.25;
        const collisions = 1.125;
        const perShip = this.craft.pointValue * diffMult * collisions;
        let points = this.count * perShip;
        const captureCount = this.captureCount;
        points += 4 * captureCount * perShip; // captured craft are worth 5x, so add 4x to the kill points for each capturable craft.
        return Math.ceil(points);
    }
    get isFriendly() {
        if (this.PlayerCraft) {
            return true;
        }
        else if (this.Iff === 1) {
            // TODO constants enum stuff
            return true;
        }
        return false;
    }
    get arrives() {
        return true; // TODO check trigger is sensible
    }
    get count() {
        return this.NumberOfCraft * (this.NumberOfWaves + 1);
    }
    isInDifficulty(difficulty) {
        if (!this.arrives) {
            return false;
        }
        return this.ArrivalDifficultyLabel === "All" || this.ArrivalDifficultyLabel.includes(difficulty);
    }
    get primaryGoal() {
        return this.FlightGroupGoals[0];
    }
    get secondaryGoal() {
        return this.FlightGroupGoals[1];
    }
    get bonusGoal() {
        return this.FlightGroupGoals[3];
    }
    get capturable() {
        return !!this.FlightGroupGoals.find((goal) => goal.isCaptureGoal); // TODO check global goals
    }
    get captureCount() {
        return Math.max(...this.FlightGroupGoals.map((goal) => goal.captureCount(this.count)));
    }
    get destroyable() {
        return this.GroupAI !== 5 || !!this.FlightGroupGoals.find((goal) => goal.isInvincibleGoal); // TODO check global goals
    }
    afterConstruct() {
        this.craft = new Craft(this.CraftType);
    }
}

import { MissionBase } from "./gen/mission-base";
import { QuestionType } from "./pre-mission-questions";
export var Difficulty;
(function (Difficulty) {
    Difficulty["Easy"] = "Easy";
    Difficulty["Medium"] = "Medium";
    Difficulty["Hard"] = "Hard";
})(Difficulty || (Difficulty = {}));
const HARD_PTS = 7750;
const MED_PTS = 5250;
const EASY_PTS = 2750;
export class Mission extends MissionBase {
    constructor() {
        super(...arguments);
        this.valid = false;
    }
    get officerBriefing() {
        return this.PreMissionQuestions.slice(0, 4)
            .filter((q) => q.Length)
            .map((q) => {
            q.Type = QuestionType.Officer;
            return q;
        });
    }
    get secretBriefing() {
        return this.PreMissionQuestions.slice(5, 9)
            .filter((q) => q.Length)
            .map((q) => {
            q.Type = QuestionType.Secret;
            return q;
        });
    }
    getIFF(iff) {
        let IFFs = ["Rebel", "Imperial"];
        IFFs = IFFs.concat(this.FileHeader.OtherIffNames);
        let IFFName = IFFs[iff] && IFFs[iff].trim() ? IFFs[iff] : `Unknown IFF ${iff}`;
        if (!isNaN(parseInt(IFFName[0], 10))) {
            IFFName = `${IFFName.substr(1)} (hostile)`;
        }
        return IFFName;
    }
    getFlightGroup(fg) {
        return this.FlightGroups[fg];
    }
    getGlobalGroup(gg) {
        return this.FlightGroups.filter((fg) => fg.GlobalGroup === gg);
    }
    goalPoints(diff) {
        if (diff == Difficulty.Hard) {
            return HARD_PTS;
        }
        else if (diff === Difficulty.Medium) {
            return MED_PTS;
        }
        return EASY_PTS;
    }
    getPlayerCraft(diff) {
        return this.FlightGroups.find((fg) => {
            return fg.PlayerCraft && fg.isInDifficulty(diff);
        });
    }
    beforeConstruct() {
        this.TIE = this;
    }
    afterConstruct() {
        this.valid = true;
    }
}

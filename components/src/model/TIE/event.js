import { Constants } from "./constants";
import { EventBase } from "./gen/event-base";
export var EventType;
(function (EventType) {
    EventType[EventType["PageBreak"] = 3] = "PageBreak";
    EventType[EventType["TitleText"] = 4] = "TitleText";
    EventType[EventType["CaptionText"] = 5] = "CaptionText";
    EventType[EventType["MoveMap"] = 6] = "MoveMap";
    EventType[EventType["ZoomMap"] = 7] = "ZoomMap";
    EventType[EventType["ClearFGTags"] = 8] = "ClearFGTags";
    EventType[EventType["FGTag1"] = 9] = "FGTag1";
    EventType[EventType["FGTag8"] = 16] = "FGTag8";
    EventType[EventType["ClearTextTags"] = 17] = "ClearTextTags";
    EventType[EventType["TextTag1"] = 18] = "TextTag1";
    EventType[EventType["TextTag8"] = 25] = "TextTag8";
})(EventType || (EventType = {}));
export class Event extends EventBase {
    toString() {
        let extra = "";
        if (this.EventType === 4 || this.EventType === 5) {
            // title or captions
            extra = this.Briefing.Strings[this.Variables[0]].Text;
        }
        else if (this.EventType >= 9 && this.EventType <= 16) {
            const fg = this.TIE.getFlightGroup(this.Variables[0]);
            extra = `FG lookup ${fg.toString()}`;
        }
        else if (this.EventType >= 18 && this.EventType <= 25) {
            const v = this.Variables;
            const t = this.Briefing.Tags[v[0]].Text;
            const col = Constants.TEXTTAGCOLOR[v[3]];
            extra = `${t} at ${v[1]},${v[2]} ${col}`;
        }
        else if (this.Variables.length) {
            extra = "Vars " + this.Variables.join(", ");
        }
        return `${this.EventTypeLabel} ${extra} @ ${this.Time}`;
    }
    get Text() {
        if (this.EventType === 4 || this.EventType === 5) {
            return this.Briefing.Strings[this.Variables[0]].Text;
        }
        else if (this.EventType >= 18 && this.EventType <= 25) {
            return this.Briefing.Tags[this.Variables[0]].Text;
        }
        else {
            return "Unknown Text";
        }
    }
    VariableCount() {
        if (Event.countData.hasOwnProperty(this.EventType)) {
            return Event.countData[this.EventType];
        }
        throw new Error(`Event.VariableCount - Unknown for ${this.EventType}`);
    }
}
Event.countData = {
    3: 0,
    4: 1,
    5: 1,
    6: 2,
    7: 2,
    8: 0,
    9: 1,
    10: 1,
    11: 1,
    12: 1,
    13: 1,
    14: 1,
    15: 1,
    16: 1,
    17: 0,
    18: 4,
    19: 4,
    20: 4,
    21: 4,
    22: 4,
    23: 4,
    24: 4,
    25: 4,
    34: 0
};

import { PreMissionQuestionsBase } from "./gen/pre-mission-questions-base";
export var QuestionType;
(function (QuestionType) {
    QuestionType["Officer"] = "Officer";
    QuestionType["Secret"] = "Secret";
})(QuestionType || (QuestionType = {}));
export class PreMissionQuestions extends PreMissionQuestionsBase {
    afterConstruct() {
        if (this.Length === 0) {
            this.PreMissionQuestionsLength = 2;
        }
    }
    QuestionLength() {
        if (this.Length === 0) {
            return 0;
        }
        let text = String.fromCharCode.apply(null, new Uint8Array(this.hex.slice(2)));
        text = text.substr(0, this.Length);
        const splitter = String.fromCharCode(10);
        if (text.includes(splitter)) {
            const idx = text.indexOf(splitter);
            return idx;
        }
    }
    AnswerLength() {
        if (this.Length === 0) {
            return 0;
        }
        let text = String.fromCharCode.apply(null, new Uint8Array(this.hex.slice(2)));
        text = text.substr(0, this.Length);
        const splitter = String.fromCharCode(10);
        if (text.includes(splitter)) {
            const idx = text.indexOf(splitter);
            return this.Length - idx - 1;
        }
    }
}

import { PostMissionQuestionsBase } from "./gen/post-mission-questions-base";
export class PostMissionQuestions extends PostMissionQuestionsBase {
    afterConstruct() {
        if (this.Length === 0) {
            this.PostMissionQuestionsLength = 2;
        }
    }
    QuestionLength() {
        if (this.Length === 0) {
            return 0;
        }
        let text = String.fromCharCode.apply(null, new Uint8Array(this.hex.slice(4)));
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
        let text = String.fromCharCode.apply(null, new Uint8Array(this.hex.slice(4)));
        text = text.substr(0, this.Length);
        const splitter = String.fromCharCode(10);
        if (text.includes(splitter)) {
            const idx = text.indexOf(splitter);
            return this.Length - idx - 3;
        }
    }
}

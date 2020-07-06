import { Constants } from "../constants";
import { getByte, getChar, getShort, writeByte, writeChar, writeShort } from "../../hex";
import { PyriteBase } from "../../pyrite-base";
// tslint:disable member-ordering
// tslint:disable prefer-const
export class PostMissionQuestionsBase extends PyriteBase {
    constructor(hex, tie) {
        super(hex, tie);
        this.PostMissionQuestionsLength = 0;
        this.beforeConstruct();
        let offset = 0;
        this.Length = getShort(hex, 0x0);
        if (this.Length === 0) {
            this.afterConstruct();
            return;
        }
        this.QuestionCondition = getByte(hex, 0x2);
        this.QuestionType = getByte(hex, 0x3);
        this.Question = getChar(hex, 0x4, this.QuestionLength());
        offset = 0x4;
        offset += this.QuestionLength();
        this.Reserved = getByte(hex, offset);
        offset += 1;
        this.Answer = getChar(hex, offset, this.AnswerLength());
        offset += this.AnswerLength();
        this.PostMissionQuestionsLength = offset;
        this.afterConstruct();
    }
    toJSON() {
        return {
            Length: this.Length,
            QuestionCondition: this.QuestionConditionLabel,
            QuestionType: this.QuestionTypeLabel,
            Question: this.Question,
            Reserved: this.Reserved,
            Answer: this.Answer
        };
    }
    get QuestionConditionLabel() {
        return Constants.QUESTIONCONDITION[this.QuestionCondition] || "Unknown";
    }
    get QuestionTypeLabel() {
        return Constants.QUESTIONTYPE[this.QuestionType] || "Unknown";
    }
    toHexString() {
        const hex = "";
        let offset = 0;
        writeShort(hex, this.Length, 0x0);
        if (this.Length === 0) {
            return;
        }
        writeByte(hex, this.QuestionCondition, 0x2);
        writeByte(hex, this.QuestionType, 0x3);
        writeChar(hex, this.Question, 0x4, this.QuestionLength());
        offset = 0x4;
        offset += this.QuestionLength();
        writeByte(hex, this.Reserved, offset);
        offset += 1;
        writeChar(hex, this.Answer, offset, this.AnswerLength());
        offset += this.AnswerLength();
        return hex;
    }
    getLength() {
        return this.PostMissionQuestionsLength;
    }
}

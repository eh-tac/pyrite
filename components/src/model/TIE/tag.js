import { TagBase } from "./gen/tag-base";
export class Tag extends TagBase {
    toString() {
        return this.Text;
    }
    afterConstruct() {
        this.TagLength = this.Length + 2;
    }
}

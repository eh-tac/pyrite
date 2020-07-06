import { TIEStringBase } from "./gen/tie-string-base";
export class TIEString extends TIEStringBase {
    toString() {
        return this.Text;
    }
    afterConstruct() {
        this.TIEStringLength = this.Length + 2;
    }
}

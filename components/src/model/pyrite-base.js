export class PyriteBase {
    constructor(hex, TIE) {
        this.hex = hex;
        this.TIE = TIE;
    }
    // public compareHex(other: string): boolean {
    //   return this.hex === other;
    // }
    beforeConstruct() { }
    afterConstruct() { }
}

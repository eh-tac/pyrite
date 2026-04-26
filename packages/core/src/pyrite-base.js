"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.PyriteBase = exports.DataType = void 0;
var DataType;
(function (DataType) {
    DataType[DataType["char"] = 0] = "char";
    DataType[DataType["SELECT"] = 1] = "SELECT";
})(DataType || (exports.DataType = DataType = {}));
class PyriteBase {
    constructor(hex, TIE) {
        this.hex = hex;
        this.TIE = TIE;
    }
    // public compareHex(other: string): boolean {
    //   return this.hex === other;
    // }
    beforeConstruct() { }
}
exports.PyriteBase = PyriteBase;
//# sourceMappingURL=pyrite-base.js.map
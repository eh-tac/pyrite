"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.shootInfo = shootInfo;
exports.percent = percent;
function shootInfo(hit, fired) {
    return `${hit.toLocaleString()} / ${fired.toLocaleString()}`;
}
function percent(hit, fired) {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
}
//# sourceMappingURL=index.js.map
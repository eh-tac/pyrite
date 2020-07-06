import { getByte } from "../../hex";
import { Glyph } from "./glyph";
// http://www.descent2.com/ddn/specs/fnt/
export class FontFile {
    constructor(hex) {
        this.glyphs = [];
        // worry about read length 4 later
        let off = 1;
        this.h = getByte(hex, off); // all glyphs will have this height. width can vary.
        let count = 0;
        for (count; off < hex.byteLength; count++) {
            off += this.h * 2 + 2;
        }
        off = 0;
        for (let i = 0; i < count; i++) {
            const w = getByte(hex, off);
            off += 2;
            this.glyphs.push(new Glyph(hex.slice(off), w, this.h));
            this.glyphs.push(new Glyph(hex.slice(off + 1), w, this.h));
            off += this.h * 2;
        }
    }
    getGlyphs(text) {
        const normal = this.normalGlyphs;
        const sequence = [];
        for (const char of text) {
            const code = char.charCodeAt(0);
            if (!code) {
                continue;
            }
            const g = normal[code - 32];
            if (g) {
                g.code = code;
                g.char = char;
                sequence.push(g.clone());
            }
        }
        return sequence;
    }
    get normalGlyphs() {
        return this.glyphs.filter((g, i) => i % 2 === 0);
    }
    get invertedGlyphs() {
        return this.glyphs.filter((g, i) => i % 2 === 1);
    }
}

import { getByte, getByteString } from "../../hex";
export class Glyph {
    constructor(hex, w, h) {
        this.w = w;
        this.h = h;
        this.data = [];
        this.data = [];
        this.image = new ImageData(w, h);
        if (!hex) {
            return;
        }
        let off = 0;
        let i = 0;
        for (let y = 0; y < h; y++) {
            const char = getByte(hex, off);
            const bin = getByteString(char);
            const str = bin.substr(0, this.w);
            for (let x = 0; x < w; x++) {
                const on = str[x] === "1";
                this.image.data[i + 0] = on ? 255 : 0;
                this.image.data[i + 1] = on ? 128 : 0;
                this.image.data[i + 2] = on ? 128 : 0;
                this.image.data[i + 3] = 255;
                i += 4;
            }
            this.data.push(str);
            off += 2;
        }
    }
    clone() {
        const clone = new Glyph(undefined, this.w, this.h);
        clone.data = this.data;
        clone.image = new ImageData(this.image.data.slice(0), this.w, this.h);
        clone.code = this.code;
        clone.char = this.char;
        return clone;
    }
    rgb(r, g, b) {
        const clone = this.clone();
        for (let i = 0; i < clone.image.data.length; i += 4) {
            const on = this.image.data[i] === 255;
            clone.image.data[i + 0] = on ? r : 0;
            clone.image.data[i + 1] = on ? g : 0;
            clone.image.data[i + 2] = on ? b : 0;
            clone.image.data[i + 3] = on ? 255 : 0;
        }
        return clone;
    }
    toString() {
        return this.data.join("\n");
    }
    get ImageBitmap() {
        const off = new OffscreenCanvas(this.w, this.h);
        const ctx = off.getContext("2d");
        ctx.putImageData(this.image, 0, 0);
        return off.transferToImageBitmap();
    }
    get startHighlight() {
        return this.char === "[";
    }
    get endHighlight() {
        return this.char === "]";
    }
}

export function getBool(hex, start = 0) {
    const byte = getByte(hex, start);
    return !!byte;
}
export function getByte(hex, start = 0) {
    return new Uint8Array(hex, start)[0];
}
export function getByteString(byte) {
    let bin = byte.toString(2);
    while (bin.length < 8) {
        bin = "0" + bin;
    }
    return bin;
}
export function getSByte(hex, start = 0) {
    return new Int8Array(hex, start)[0];
}
export function getSChar(hex, start = 0, length = 0) {
    return String.fromCharCode.apply(null, new Int8Array(hex, start, length));
}
export function getChar(hex, start = 0, length = 0) {
    let str = String.fromCharCode.apply(null, new Uint8Array(hex, start, length));
    const end = str.indexOf(String.fromCharCode(0));
    if (end !== -1) {
        str = str.substr(0, end);
    }
    return str.trim();
}
export function getShort(hex, start = 0) {
    return new Int16Array(hex, start, 1)[0];
}
export function getUShort(hex, start = 0) {
    return new Uint16Array(hex, start, 1)[0];
}
export function getInt(hex, start = 0) {
    hex = hex.slice(start);
    return new Int32Array(hex, 0, 1)[0];
}
export function getIntArray(hex, start = 0, count = 1) {
    hex = hex.slice(start);
    return Array.from(new Int32Array(hex, 0, count));
}
export function getUInt(hex, start = 0) {
    hex = hex.slice(start);
    return new Uint32Array(hex, 0, 1)[0];
}
export function getString(hex, start = 0, length = 99999) {
    let str = String.fromCharCode.apply(null, new Uint8Array(hex.slice(start)));
    const end = str.indexOf(String.fromCharCode(0));
    if (end !== -1) {
        str = str.substr(0, end);
    }
    return str.trim();
}
export function writeBool(hex, value, start = 0) {
    // const byte = getByte(hex, start);
    // return !!byte;
}
export function writeByte(hex, value, start = 0) {
    // return new Uint8Array(hex, start)[0];
}
export function writeSByte(hex, value, start = 0) {
    // return new Int8Array(hex, start)[0];
}
export function writeChar(hex, value, length = 1, start = 0) {
    // return String.fromCharCode.apply(null, new Uint8Array(hex, start, length));
}
export function writeShort(hex, value, start = 0) {
    // return new Int16Array(hex, start, 1)[0];
}
export function writeInt(hex, value, start = 0) {
    // return new Int32Array(hex, start, 1)[0];
}
export function writeString(hex, value, start = 0, length = 99999) {
    hex = hex.substring(start, start + length);
    const end = hex.indexOf(String.fromCharCode(0));
    if (end !== -1) {
        hex = hex.substr(0, end);
    }
}
export function writeObject(hex, value, position) { }

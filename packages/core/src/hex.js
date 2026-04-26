"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.getBool = getBool;
exports.getByte = getByte;
exports.getByteString = getByteString;
exports.getSByte = getSByte;
exports.getSChar = getSChar;
exports.getChar = getChar;
exports.getShort = getShort;
exports.getUShort = getUShort;
exports.getInt = getInt;
exports.getIntArray = getIntArray;
exports.getUInt = getUInt;
exports.getString = getString;
exports.writeBool = writeBool;
exports.writeByte = writeByte;
exports.writeSByte = writeSByte;
exports.writeChar = writeChar;
exports.writeShort = writeShort;
exports.writeUShort = writeUShort;
exports.writeInt = writeInt;
exports.writeString = writeString;
exports.writeObject = writeObject;
function getBool(hex, start = 0) {
    const byte = getByte(hex.slice(start));
    return !!byte;
}
function getByte(hex, start = 0) {
    return new Uint8Array(hex.slice(start))[0];
}
function getByteString(byte) {
    let bin = byte.toString(2);
    while (bin.length < 8) {
        bin = "0" + bin;
    }
    return bin;
}
function getSByte(hex, start = 0) {
    return new Int8Array(hex.slice(start))[0];
}
function getSChar(hex, start = 0, length = 0) {
    return String.fromCharCode.apply(null, new Int8Array(hex.slice(start), length));
}
function getChar(hex, start = 0, length = 0) {
    let str = String.fromCharCode.apply(null, new Uint8Array(hex.slice(start, start + length)));
    const end = str.indexOf(String.fromCharCode(0));
    if (end !== -1) {
        str = str.substr(0, end);
    }
    return str.trim();
}
function getShort(hex, start = 0) {
    return new Int16Array(hex.slice(start), 0, 1)[0];
}
function getUShort(hex, start = 0) {
    return new Uint16Array(hex.slice(start), 0, 1)[0];
}
function getInt(hex, start = 0) {
    return new Int32Array(hex.slice(start), 0, 1)[0];
}
function getIntArray(hex, start = 0, count = 1) {
    return Array.from(new Int32Array(hex.slice(start), 0, count));
}
function getUInt(hex, start = 0) {
    return new Uint32Array(hex.slice(start), 0, 1)[0];
}
function getString(hex, start = 0, length = 99999) {
    let str = String.fromCharCode.apply(null, new Uint8Array(hex.slice(start, length)));
    const end = str.indexOf(String.fromCharCode(0));
    if (end !== -1) {
        str = str.substr(0, end);
    }
    return str.trim();
}
function writeBool(hex, value, start = 0) {
    // const byte = getByte(hex, start);
    // return !!byte;
}
function writeByte(hex, value, start = 0) {
    // return new Uint8Array(hex, start)[0];
}
function writeSByte(hex, value, start = 0) {
    // return new Int8Array(hex, start)[0];
}
function writeChar(hex, value, length = 1, start = 0) {
    // return String.fromCharCode.apply(null, new Uint8Array(hex, start, length));
}
function writeShort(hex, value, start = 0) {
    // return new Int16Array(hex, start, 1)[0];
}
function writeUShort(hex, value, start = 0) {
    // return new UInt16Array(hex, start, 1)[0];
}
function writeInt(hex, value, start = 0) {
    // return new Int32Array(hex, start, 1)[0];
}
function writeString(hex, value, start = 0, length = 99999) {
    hex = hex.substring(start, start + length);
    const end = hex.indexOf(String.fromCharCode(0));
    if (end !== -1) {
        hex = hex.substr(0, end);
    }
}
function writeObject(hex, value, position) { }
//# sourceMappingURL=hex.js.map
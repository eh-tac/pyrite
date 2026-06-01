import { Byteable } from './byteable';

export function getBool(hex: ArrayBuffer, start: number = 0): boolean {
  return new DataView(hex).getUint8(start) !== 0;
}

export function getByte(hex: ArrayBuffer, start: number = 0): number {
  return new DataView(hex).getUint8(start);
}

export function getByteString(byte: number): string {
  let bin = byte.toString(2);
  while (bin.length < 8) {
    bin = '0' + bin;
  }
  return bin;
}

export function getSByte(hex: ArrayBuffer, start: number = 0): number {
  return new DataView(hex).getInt8(start);
}

export function getSChar(hex: ArrayBuffer, start: number = 0, length: number = 0): string {
  return String.fromCharCode.apply(null, Array.from(new Int8Array(hex.slice(start), length)));
}

export function getChar(hex: ArrayBuffer, start: number = 0, length: number = 0): string {
  let str: string = String.fromCharCode.apply(null, Array.from(new Uint8Array(hex, start, length)));
  const end = str.indexOf(String.fromCharCode(0));
  if (end !== -1) {
    str = str.substr(0, end);
  }
  return str.trim();
}

export function getShort(hex: ArrayBuffer, start: number = 0): number {
  return new DataView(hex).getInt16(start, true);
}

export function getUShort(hex: ArrayBuffer, start: number = 0): number {
  return new DataView(hex).getUint16(start, true);
}

export function getInt(hex: ArrayBuffer, start: number = 0): number {
  return new DataView(hex).getInt32(start, true);
}

export function getIntArray(hex: ArrayBuffer, start: number = 0, count: number = 1): number[] {
  const view = new DataView(hex);
  return Array.from({ length: count }, (_, i) => view.getInt32(start + i * 4, true));
}

export function getUInt(hex: ArrayBuffer, start: number = 0): number {
  return new DataView(hex).getUint32(start, true);
}

export function getString(hex: ArrayBuffer, start: number = 0, length: number = 99999): string {
  const actualLength = Math.min(length, hex.byteLength - start);
  let str = String.fromCharCode.apply(null, Array.from(new Uint8Array(hex, start, actualLength)));
  const end = str.indexOf(String.fromCharCode(0));
  if (end !== -1) {
    str = str.substr(0, end);
  }
  return str.trim();
}

export function writeBool(hex: ArrayBuffer, value: boolean, pos: number = 0): void {
  writeByte(hex, value ? 1 : 0, pos);
}

export function writeByte(hex: ArrayBuffer, value: number, pos: number = 0): void {
  new Uint8Array(hex)[pos] = value & 0xff;
}

export function writeSByte(hex: ArrayBuffer, value: number, pos: number = 0): void {
  new Int8Array(hex)[pos] = value;
}

export function writeChar(
  hex: ArrayBuffer,
  value: string,
  pos: number = 0,
  length: number = 1
): void {
  const view = new Uint8Array(hex);
  for (let i = 0; i < length; i++) {
    view[pos + i] = i < value.length ? value.charCodeAt(i) : 0;
  }
}

export function writeShort(hex: ArrayBuffer, value: number, pos: number = 0): void {
  new DataView(hex).setInt16(pos, value, true);
}

export function writeUShort(hex: ArrayBuffer, value: number, pos: number = 0): void {
  new DataView(hex).setUint16(pos, value, true);
}

export function writeInt(hex: ArrayBuffer, value: number, pos: number = 0): void {
  new DataView(hex).setInt32(pos, value, true);
}

export function writeString(
  hex: ArrayBuffer,
  value: string,
  pos: number = 0,
  length: number = 99999
): void {
  const view = new Uint8Array(hex);
  const maxLength = Math.min(length, value.length);
  for (let i = 0; i < maxLength; i++) {
    view[pos + i] = value.charCodeAt(i);
  }
  if (maxLength < length) {
    view[pos + maxLength] = 0;
  }
}

export function writeObject(hex: ArrayBuffer, value: Byteable, pos: number): void {
  const valueView = new DataView(value.toHexBuffer());
  const view = new DataView(hex);
  for (let i = 0; i < valueView.byteLength; i++) {
    view.setUint8(pos + i, valueView.getUint8(i));
  }
}

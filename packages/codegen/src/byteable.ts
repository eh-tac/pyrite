export interface Byteable {
  getLength(): number;
  toHexBuffer(): ArrayBuffer;
}

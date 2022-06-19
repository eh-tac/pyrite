import { getChar, getInt, getUInt } from "../../hex";
import { IMission } from "../pyrite-base";
import { VoicBase } from "./base/voic-base";
import { VoicData } from "./voic-data";

/**
 * Creative Voice File (VOC) Format:

    HEADER (bytes 00-19)
    Series of DATA BLOCKS (bytes 1A+) [Must end w/ Terminator Block]

-----------------------------------------------------------------

HEADER:
=======
     byte #     Description
     ------     ------------------------------------------
     00-12      Creative Voice File
     13-15      1A 1A 00  (eof to abort printing of file)
     16-17      Version number (minor,major) (VOC-HDR puts 0A 01)
     18-19      2's Comp of Ver. # + 1234h (VOC-HDR puts 29 11)
 */
export class Voic extends VoicBase {
  public d: VoicData[] = [];
  protected DataCount(): number {
    return this.Header.Length - 0x1a;
  }
  protected loadData() {
    throw new Error("Method not implemented.");
  }
  protected writeData() {
    throw new Error("Method not implemented.");
  }

  public constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.VoicLength = this.Header.Length + 16;
  }

  public toString(): string {
    return "";
  }

  public base64(): string {
    const prefix = "data:audio/voc;base64,";
    return prefix + btoa(String.fromCharCode.apply(null, new Uint8Array(this.hex.slice(16))));
  }
}

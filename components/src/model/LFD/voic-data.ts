import { getByte, getInt } from "../../hex";
import { getUInt } from "../hex";
import { IMission } from "../pyrite-base";
import { VoicDataBase } from "./base/voic-data-base";

/**
 * 
DATA BLOCK:
===========

   Data Block:  TYPE(1-byte), SIZE(3-bytes), INFO(0+ bytes)
   NOTE: Terminator Block is an exception -- it has only the TYPE byte.

      TYPE   Description     Size (3-byte int)   Info
      ----   -----------     -----------------   -----------------------
      00     Terminator      (NONE)              (NONE)
      01     Sound data      2+length of data    *
      02     Sound continue  length of data      Voice Data
      03     Silence         3                   **
      04     Marker          2                   Marker# (2 bytes)
      05     ASCII           length of string    null terminated string
      06     Repeat          2                   Count# (2 bytes)
      07     End repeat      0                   (NONE)

      *Sound Info Format:       **Silence Info Format:
       ---------------------      ----------------------------
       00   Sample Rate           00-01  Length of silence - 1
       01   Compression Type      02     Sample Rate
       02+  Voice Data


  Marker#           -- Driver keeps the most recent marker in a status byte
  Count#            -- Number of repetitions + 1
                         Count# may be 1 to FFFE for 0 - FFFD repetitions
                         or FFFF for endless repetitions
  Sample Rate       -- SR byte = 256-(1000000/sample_rate)
  Length of silence -- in units of sampling cycle
  Compression Type  -- of voice data
                         8-bits    = 0
                         4-bits    = 1
                         2.6-bits  = 2
                         2-bits    = 3
                         Multi DAC = 3+(# of channels) [interesting--
                                       this isn't in the developer's manual]

 */
export class VoicData extends VoicDataBase {
  protected loadData() {
    const offset = 0x06;
    // the size is stored as a 3 byte integer
    // for who knows what reason.
    // grab 4 bytes, set the last to 0 and get the int.
    const three = new Int8Array(this.hex.slice(1, 5));
    three[3] = 0;
    const size = getInt(three.buffer) - 2;

    this.Data = new Uint8Array(this.hex.slice(offset, offset + size));
    this.VoicDataLength = size + 6;
  }
  protected writeData() {
    throw new Error("Method not implemented.");
  }
  public sampleRate: number;
  public compressionType: number;
  public Data: Uint8Array;
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    const offset = 0x04;
    this.sampleRate = getByte(hex, offset);
    this.compressionType = getByte(hex, offset + 1);

    this.loadData();
  }
}

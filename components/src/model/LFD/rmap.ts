import { RmapBase } from "./base/rmap-base";
import { IMission } from "../../pyrite-base";
import { Header } from "./header";
import { BattleText } from "./battle-text";
import { Delt } from "./delt";
import { Voic } from "./voic";

export class Rmap extends RmapBase {
  public RawData: any[] = [];

  public beforeConstruct(): void {}

  public constructor(public hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    let offset = this.RmapLength;
    this.RawData = this.Subheaders.map((h: Header) => {
      // load the included entities. each item has a length specified by the header,
      // plus 16 bytes for the header itself which is repeated
      const d = this.loadData(hex.slice(offset, offset + h.Length + 16), h);
      offset += d.getLength();
      return d;
    });
  }

  public toString(): string {
    return "";
  }

  protected HeaderCount(): number {
    return this.Header.Length / 16;
  }

  private loadData(hex: ArrayBuffer, header: Header): any {
    if (header.Type === "TEXT") {
      const t = new BattleText(hex);
      return t;
    } else if (header.Type === "DELT") {
      return new Delt(hex);
    } else if (header.Type === "VOIC") {
      return new Voic(hex);
    }
    return 0;
  }
}

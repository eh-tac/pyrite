import { LFDBase } from "./base/lfd-base";
import { Rmap } from "./rmap";

export class LFD extends LFDBase {
  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }

  public static load(hex: ArrayBuffer): any {
    const lfd = new LFD(hex);

    const type = lfd.Header.Type;
    switch (type) {
      case "RMAP":
        return new Rmap(hex);
    }

    return lfd;
  }
}

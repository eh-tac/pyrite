import { IMission } from "../../pyrite-base";
import { BriefingBase } from "./base/briefing-base";
import { Event } from "./event";

export class Briefing extends BriefingBase {
  constructor(hex: ArrayBuffer, TIE?: IMission) {
    super(hex, TIE!);
    // reparse events because the logic is complicated and based on the EventsLength prop
    let offset = 0x000a; // start of events
    let eventParsed = 0;
    while (eventParsed < this.EventsLength * 2) {
      const t = new Event(hex.slice(offset), this.TIE);
      this.Events.push(t);
      offset += t.getLength();
      eventParsed += t.getLength();
    }
  }

  public beforeConstruct(): void {}

  public toString(): string {
    return "";
  }
}

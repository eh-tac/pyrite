import { EventBase } from './base/event-base';
import { EventType } from './constants';

export class Event extends EventBase {
  protected VariableCount(): number {
    switch (this.Type) {
      case EventType.seek:
      case EventType.pageBreak:
      case EventType.clearFgTags:
      case EventType.clearTextTags:
      case EventType.endBriefing: {
        return 0;
      }
      case EventType.shipIndex:
      case EventType.titleText:
      case EventType.captionText:
      case EventType.fgTag1:
      case EventType.fgTag2:
      case EventType.fgTag3:
      case EventType.fgTag4:
      case EventType.fgTag5:
      case EventType.fgTag6:
      case EventType.fgTag7:
      case EventType.fgTag8:
      case EventType.changeRegion:
      case EventType.zoomParagraph: {
        return 1;
      }
      case EventType.moveMap:
      case EventType.zoomMap:
      case EventType.shipCraftData:
      case EventType.rotateIcon: {
        return 2;
      }
      case EventType.setIcon:
      case EventType.moveIcon: {
        return 3;
      }
      case EventType.textTag1:
      case EventType.textTag2:
      case EventType.textTag3:
      case EventType.textTag4:
      case EventType.textTag5:
      case EventType.textTag6:
      case EventType.textTag7:
      case EventType.textTag8: {
        return 4;
      }
    }
  }

  public beforeConstruct(): void {}

  public toString(): string {
    const varStr = `${this.Variables.length > 0 ? ` with variables ${this.Variables.join(', ')}` : ''}`;
    return `${this.TypeLabel} at ${this.Time}${varStr}`;
  }
}

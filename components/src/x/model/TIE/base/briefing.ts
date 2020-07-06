import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class BriefingBase extends PyriteBase implements Byteable {
  public BriefingLength: number;
  public RunningTime: number;
  public Unknown: number;
  public StartLength: number;
  public EventsLength: number; //Number of shorts used for events.
  public Events: Event[]; //Set to 0 and impossible to generate in the same way, needs custom implementation
  public Tags: Tag[];
  public Strings: TIEString[];

  constructor(hex: ArrayBuffer, tie?: any) {
    super(hex, tie);
  }
}

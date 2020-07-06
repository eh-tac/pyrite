import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TIEStringBase extends PyriteBase implements Byteable {
  public TIEStringLength:number;
  public Length:number;
  public Text:string;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }
}
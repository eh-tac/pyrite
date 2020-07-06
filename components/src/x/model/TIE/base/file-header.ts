import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FileHeaderBase extends PyriteBase implements Byteable {
  public static FILEHEADERLENGTH:number = 458;
  public PlatformID:number; //(-1)
  public NumFGs:number;
  public NumMessages:number;
  public static NumGGs:number = 3; //might be # of GlobalGoals
  public Unknown1:number;
  public Unknown2:boolean;
  public BriefingOfficers:number;
  public CapturedOnEject:boolean;
  public EndOfMissionMessages:string[];
  public OtherIffNames:string[];

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }

  public get BriefingOfficersLabel(): string {
    return Constants.BRIEFINGOFFICERS[this.BriefingOfficers] || "Unknown";
  }
}
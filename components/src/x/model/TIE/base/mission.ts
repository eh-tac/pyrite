import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class MissionBase extends PyriteBase implements Byteable {
  public MissionLength:number;
  public FileHeader:FileHeader;
  public FlightGroups:FlightGroup[];
  public Messages:Message[];
  public GlobalGoals:GlobalGoal[];
  public Briefing:Briefing;
  public PreMissionQuestions:PreMissionQuestions[];
  public PostMissionQuestions:PostMissionQuestions[];
  public static End:number = 255;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }
}
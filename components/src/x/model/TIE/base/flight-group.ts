import { Byteable } from "../../byteable";
import { IMission, PyriteBase } from "../../pyrite-base";
import { Constants } from "../constants";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class FlightGroupBase extends PyriteBase implements Byteable {
  public static FLIGHTGROUPLENGTH:number = 292;
  public Name:string;
  public Pilot:string;
  public Cargo:string;
  public SpecialCargo:string;
  public SpecialCargoCraft:number;
  public RandomSpecialCargoCraft:boolean;
  public CraftType:number;
  public NumberOfCraft:number;
  public Status:number;
  public Warhead:number;
  public Beam:number;
  public Iff:number;
  public GroupAI:number;
  public Markings:number;
  public ObeyPlayerOrders:boolean;
  public static Reserved1:number = 0; //Unknown1 in TFW
  public Formation:number;
  public FormationSpacing:number; //Unknown2
  public GlobalGroup:number; //Unknown3
  public LeaderSpacing:number; //Unknown4
  public NumberOfWaves:number;
  public Unknown5:number;
  public PlayerCraft:number;
  public Yaw:number; //Unknown6
  public Pitch:number; //Unknown7
  public Roll:number; //Unknown8
  public Unknown9:boolean;
  public Unknown10:number;
  public static Reserved2:number = 0; //Unknown11
  public ArrivalDifficulty:number;
  public Arrival1:Trigger;
  public Arrival2:Trigger;
  public Arrival1OrArrival2:boolean;
  public static Reserved3:number = 0; //Unknown12
  public ArrivalDelayMinutes:number;
  public ArrivalDelaySeconds:number;
  public Departure:Trigger;
  public DepartureDelayMinutes:number; //Unknown13
  public DepartureDelatSeconds:number; //Unknown14
  public AbortTrigger:number;
  public static Reserved4:number = 0; //Unknown15
  public Unknown16:number;
  public static Reserved5:number = 0; //Unknown17
  public ArrivalMothership:number;
  public ArriveViaMothership:boolean;
  public DepartureMothership:number;
  public DepartViaMothership:boolean;
  public AlternateArrivalMothership:number;
  public AlternateArriveViaMothership:boolean;
  public AlternateDepartureMothership:number;
  public AlternateDepartViaMothership:boolean;
  public Orders:Order[];
  public FlightGroupGoals:GoalFG[];
  public BonusGoalPoints:number;
  public Waypoints:Waypt[];
  public Unknown19:boolean;
  public Unknown20:number;
  public Unknown21:boolean;

  constructor(hex: ArrayBuffer, tie?: any){
      super(hex, tie);
  }

  public get CraftTypeLabel(): string {
    return Constants.CRAFTTYPE[this.CraftType] || "Unknown";
  }

  public get StatusLabel(): string {
    return Constants.STATUS[this.Status] || "Unknown";
  }

  public get WarheadLabel(): string {
    return Constants.WARHEAD[this.Warhead] || "Unknown";
  }

  public get BeamLabel(): string {
    return Constants.BEAM[this.Beam] || "Unknown";
  }

  public get GroupAILabel(): string {
    return Constants.GROUPAI[this.GroupAI] || "Unknown";
  }

  public get MarkingsLabel(): string {
    return Constants.MARKINGS[this.Markings] || "Unknown";
  }

  public get FormationLabel(): string {
    return Constants.FORMATION[this.Formation] || "Unknown";
  }

  public get ArrivalDifficultyLabel(): string {
    return Constants.ARRIVALDIFFICULTY[this.ArrivalDifficulty] || "Unknown";
  }

  public get AbortTriggerLabel(): string {
    return Constants.ABORTTRIGGER[this.AbortTrigger] || "Unknown";
  }
}
import { Byteable } from "../../../byteable";
import { IMission, PyriteBase } from "../../../pyrite-base";
import { MissionData } from "../mission-data";
import { getInt, writeInt, writeObject } from "../../../hex";
// tslint:disable member-ordering
// tslint:disable prefer-const

export abstract class TeamStatsBase extends PyriteBase implements Byteable {
  public TeamStatsLength: number;
  public MeleeMedals: number[];
  public TournamentMedals: number[];
  public MissionTopRatings: number[];
  public MissionMedals: number[];
  public PlayCounts: number[];
  public TotalKills: number[];
  public ExerciseKillsByType: number[];
  public MeleeKillsByType: number[];
  public CombatKillsByType: number[];
  public ExercisePartialsByType: number[];
  public MeleePartialsByType: number[];
  public CombatPartialsByType: number[];
  public ExerciseAssistsByType: number[];
  public MeleeAssistsByType: number[];
  public CombatAssistsByType: number[];
  public HiddenCargoFound: number[];
  public LasersHit: number[];
  public LasersTotal: number[];
  public WarheadsHit: number[];
  public WarheadsTotal: number[];
  public CraftLosses: number[];
  public CollisionLosses: number[];
  public StarshipLosses: number[];
  public MineLosses: number[];
  public TrainingMissionData: MissionData[];
  public MeleeMissionData: MissionData[];
  public CombatMissionData: MissionData[];
  
  constructor(hex: ArrayBuffer, tie?: IMission) {
    super(hex, tie);
    this.beforeConstruct();
    let offset = 0;

    this.MeleeMedals = [];
    offset = 0x0000;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.MeleeMedals.push(t);
      offset += 4;
    }
    this.TournamentMedals = [];
    offset = 0x0018;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.TournamentMedals.push(t);
      offset += 4;
    }
    this.MissionTopRatings = [];
    offset = 0x0030;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.MissionTopRatings.push(t);
      offset += 4;
    }
    this.MissionMedals = [];
    offset = 0x0048;
    for (let i = 0; i < 6; i++) {
      const t = getInt(hex, offset);
      this.MissionMedals.push(t);
      offset += 4;
    }
    this.PlayCounts = [];
    offset = 0x0090;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.PlayCounts.push(t);
      offset += 4;
    }
    this.TotalKills = [];
    offset = 0x00A8;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.TotalKills.push(t);
      offset += 4;
    }
    this.ExerciseKillsByType = [];
    offset = 0x00C0;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.ExerciseKillsByType.push(t);
      offset += 4;
    }
    this.MeleeKillsByType = [];
    offset = 0x0220;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.MeleeKillsByType.push(t);
      offset += 4;
    }
    this.CombatKillsByType = [];
    offset = 0x0380;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.CombatKillsByType.push(t);
      offset += 4;
    }
    this.ExercisePartialsByType = [];
    offset = 0x4e0;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.ExercisePartialsByType.push(t);
      offset += 4;
    }
    this.MeleePartialsByType = [];
    offset = 0x640;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.MeleePartialsByType.push(t);
      offset += 4;
    }
    this.CombatPartialsByType = [];
    offset = 0x7a0;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.CombatPartialsByType.push(t);
      offset += 4;
    }
    this.ExerciseAssistsByType = [];
    offset = 0x900;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.ExerciseAssistsByType.push(t);
      offset += 4;
    }
    this.MeleeAssistsByType = [];
    offset = 0xa60;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.MeleeAssistsByType.push(t);
      offset += 4;
    }
    this.CombatAssistsByType = [];
    offset = 0xbc0;
    for (let i = 0; i < 88; i++) {
      const t = getInt(hex, offset);
      this.CombatAssistsByType.push(t);
      offset += 4;
    }
    this.HiddenCargoFound = [];
    offset = 0x117c;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.HiddenCargoFound.push(t);
      offset += 4;
    }
    this.LasersHit = [];
    offset = 0x1188;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.LasersHit.push(t);
      offset += 4;
    }
    this.LasersTotal = [];
    offset = 0x1194;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.LasersTotal.push(t);
      offset += 4;
    }
    this.WarheadsHit = [];
    offset = 0x11a0;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.WarheadsHit.push(t);
      offset += 4;
    }
    this.WarheadsTotal = [];
    offset = 0x11ac;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.WarheadsTotal.push(t);
      offset += 4;
    }
    this.CraftLosses = [];
    offset = 0x11b8;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.CraftLosses.push(t);
      offset += 4;
    }
    this.CollisionLosses = [];
    offset = 0x11c4;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.CollisionLosses.push(t);
      offset += 4;
    }
    this.StarshipLosses = [];
    offset = 0x11d0;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.StarshipLosses.push(t);
      offset += 4;
    }
    this.MineLosses = [];
    offset = 0x11dc;
    for (let i = 0; i < 3; i++) {
      const t = getInt(hex, offset);
      this.MineLosses.push(t);
      offset += 4;
    }
    this.TrainingMissionData = [];
    offset = 0x1360;
    for (let i = 0; i < 40; i++) {
      const t = new MissionData(hex.slice(offset), this.TIE);
      this.TrainingMissionData.push(t);
      offset += t.getLength();
    }
    this.MeleeMissionData = [];
    offset = 0x2170;
    for (let i = 0; i < 100; i++) {
      const t = new MissionData(hex.slice(offset), this.TIE);
      this.MeleeMissionData.push(t);
      offset += t.getLength();
    }
    this.CombatMissionData = [];
    offset = 0x4498;
    for (let i = 0; i < 100; i++) {
      const t = new MissionData(hex.slice(offset), this.TIE);
      this.CombatMissionData.push(t);
      offset += t.getLength();
    }
    this.TeamStatsLength = offset;
  }
  
  public toJSON(): object {
    return {
      MeleeMedals: this.MeleeMedals,
      TournamentMedals: this.TournamentMedals,
      MissionTopRatings: this.MissionTopRatings,
      MissionMedals: this.MissionMedals,
      PlayCounts: this.PlayCounts,
      TotalKills: this.TotalKills,
      ExerciseKillsByType: this.ExerciseKillsByType,
      MeleeKillsByType: this.MeleeKillsByType,
      CombatKillsByType: this.CombatKillsByType,
      ExercisePartialsByType: this.ExercisePartialsByType,
      MeleePartialsByType: this.MeleePartialsByType,
      CombatPartialsByType: this.CombatPartialsByType,
      ExerciseAssistsByType: this.ExerciseAssistsByType,
      MeleeAssistsByType: this.MeleeAssistsByType,
      CombatAssistsByType: this.CombatAssistsByType,
      HiddenCargoFound: this.HiddenCargoFound,
      LasersHit: this.LasersHit,
      LasersTotal: this.LasersTotal,
      WarheadsHit: this.WarheadsHit,
      WarheadsTotal: this.WarheadsTotal,
      CraftLosses: this.CraftLosses,
      CollisionLosses: this.CollisionLosses,
      StarshipLosses: this.StarshipLosses,
      MineLosses: this.MineLosses,
      TrainingMissionData: this.TrainingMissionData,
      MeleeMissionData: this.MeleeMissionData,
      CombatMissionData: this.CombatMissionData
    };
  }
  
  public toHexString(): string {
    let hex: string = '';
    let offset = 0;

    offset = 0x0000;
    for (let i = 0; i < 6; i++) {
      const t = this.MeleeMedals[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0018;
    for (let i = 0; i < 6; i++) {
      const t = this.TournamentMedals[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0030;
    for (let i = 0; i < 6; i++) {
      const t = this.MissionTopRatings[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0048;
    for (let i = 0; i < 6; i++) {
      const t = this.MissionMedals[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0090;
    for (let i = 0; i < 3; i++) {
      const t = this.PlayCounts[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x00A8;
    for (let i = 0; i < 3; i++) {
      const t = this.TotalKills[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x00C0;
    for (let i = 0; i < 88; i++) {
      const t = this.ExerciseKillsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0220;
    for (let i = 0; i < 88; i++) {
      const t = this.MeleeKillsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x0380;
    for (let i = 0; i < 88; i++) {
      const t = this.CombatKillsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x4e0;
    for (let i = 0; i < 88; i++) {
      const t = this.ExercisePartialsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x640;
    for (let i = 0; i < 88; i++) {
      const t = this.MeleePartialsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x7a0;
    for (let i = 0; i < 88; i++) {
      const t = this.CombatPartialsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x900;
    for (let i = 0; i < 88; i++) {
      const t = this.ExerciseAssistsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0xa60;
    for (let i = 0; i < 88; i++) {
      const t = this.MeleeAssistsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0xbc0;
    for (let i = 0; i < 88; i++) {
      const t = this.CombatAssistsByType[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x117c;
    for (let i = 0; i < 3; i++) {
      const t = this.HiddenCargoFound[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1188;
    for (let i = 0; i < 3; i++) {
      const t = this.LasersHit[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1194;
    for (let i = 0; i < 3; i++) {
      const t = this.LasersTotal[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x11a0;
    for (let i = 0; i < 3; i++) {
      const t = this.WarheadsHit[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x11ac;
    for (let i = 0; i < 3; i++) {
      const t = this.WarheadsTotal[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x11b8;
    for (let i = 0; i < 3; i++) {
      const t = this.CraftLosses[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x11c4;
    for (let i = 0; i < 3; i++) {
      const t = this.CollisionLosses[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x11d0;
    for (let i = 0; i < 3; i++) {
      const t = this.StarshipLosses[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x11dc;
    for (let i = 0; i < 3; i++) {
      const t = this.MineLosses[i];
      writeInt(hex, t, offset);
      offset += 4;
    }
    offset = 0x1360;
    for (let i = 0; i < 40; i++) {
      const t = this.TrainingMissionData[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x2170;
    for (let i = 0; i < 100; i++) {
      const t = this.MeleeMissionData[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }
    offset = 0x4498;
    for (let i = 0; i < 100; i++) {
      const t = this.CombatMissionData[i];
      writeObject(hex, t, offset);
      offset += t.getLength();
    }

    return hex;
  }
  
  
  public getLength(): number {
    return this.TeamStatsLength;
  }
}
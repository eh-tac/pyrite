import { getInt, getIntArray } from "../hex";
import { XvTMission } from "./xvt-mission";

const craftString = `00	None
01	X-wing
02	Y-wing
03	A-wing
04	B-wing
05	TIE Fighter
06	TIE Interceptor
07	TIE Bomber
08	TIE Advanced
09	*TIE Defender
0A	Unused
0B	Unused
0C	*Missile Boat
0D	T-wing
0E	Z-95 Headhunter
0F	R-41 Starchaser
10	Assault Gunboat
11	Shuttle
12	Escort Shuttle
13	System Patrol Craft
14	*Scout Craft
15	Stormtrooper Transport
16	Assault Transport
17	Escort Transport
18	Tug
19	Combat Utility Vehicle
1A	Container A
1B	Container B
1C	Container C
1D	Container D
1E	Heavy Lifter
1F	Unused
20	Bulk Freighter
21	Cargo Ferry
22	Modular Conveyor
23	*Container Transport
24	Medium Transport
25	Murrian Transport
26	Corellian Transport
27	Unused
28	Corellian Corvette
29	Modified Corvette
2A	Nebulon-B Frigate
2B	Modified Frigate
2C	*C-3 Passenger Liner
2D	*Carrack Cruiser
2E	Strike Cruiser
2F	Escort Carrier
30	Dreadnaught
31	Mon Calamari Cruiser
32	Light Mon Calamari Cruiser
33	Interdictor Cruiser
34	Victory-class Star Destroyer
35	Imperator-class Star Destroyer
36	Executor-class Star Destroyer
37	Container E
38	Container F
39	Container G
3A	Container H
3B	Container I
3C	Platform A
3D	Platform B
3E	Platform C
3F	Platform D
40	Platform E
41	Platform F
42	Asteroid R&D Station
43	Asteroid Laser Battery
44	Asteroid Warhead Battery
45	X/7 Factory
46	Satellite 1
47	Satellite 2
48	Unused
49	Unused
4A	Unused
4B	Mine A
4C	Mine B
4D	Mine C
4E	Gun Emplacement
4F	Unused
50	Probe A
51	Probe B
52	Unused
53	Nav Buoy A
54	Nav Buoy B
55	Unused
56	Asteroid Field
57	Planet
58	Unused
59	Unused
5A	Shipyard
5B	Repair Yard
5C	Modified Strike Cruiser`;

const craft: string[] = [];
craftString.split("\n").forEach(s => {
  const n = parseInt(s.substr(0, 2), 16);
  craft[n] = s.substr(3);
});
const shipCount = parseInt("5C", 16);

enum MedalTypes {
  Gold = 0,
  Silver = 1,
  Bronze = 2,
  Thing = 3,
  Thingo = 4,
  Lead = 5
}
const medals = ["Gold", "Silver", "Bronze", "Nickel", "Copper", "Lead"];
const modeCount = 3;
const missionCount = 100;

export interface TriStat {
  Label: string;
  Exercise: string | number;
  Melee: string | number;
  Combat: string | number;
}

export class XvTTeamStats {
  public meleeMedals: number[];
  public tournamentMedals: number[];
  public missionTopRatings: number[];
  public missionMedals: number[];
  public playCounts: number[];
  public kills: number[];

  public exerciseKillsByType: number[];
  public meleeKillsByType: number[];
  public combatKillsByType: number[];
  public exercisePartialsByType: number[];
  public meleePartialsByType: number[];
  public combatPartialsByType: number[];
  public exerciseAssistsByType: number[];
  public meleeAssistsByType: number[];
  public combatAssistsByType: number[];

  public hiddenCargoFound: number[];
  public lasersHit: number[];
  public lasersFired: number[];
  public warheadsHit: number[];
  public warheadsFired: number[];
  public craftLosses: number[];
  public collisionLosses: number[];
  public starshipLosses: number[];
  public mineLosses: number[];
  public trainingMissions: XvTMission[];
  public meleeMissions: XvTMission[];
  public combatMissions: XvTMission[];
  // other stuff about battles; attempts, best scores, plaque

  constructor(public name: string, hex: ArrayBuffer) {
    this.meleeMedals = getIntArray(hex, 0x0, 6);
    this.tournamentMedals = getIntArray(hex, 0x18, 6);
    this.missionTopRatings = getIntArray(hex, 0x30, 6);
    this.missionMedals = getIntArray(hex, 0x48, 6);
    this.playCounts = getIntArray(hex, 0x90, 3);
    this.kills = getIntArray(hex, 0xa8, 3);

    this.exerciseKillsByType = getIntArray(hex, 0xc0, shipCount);
    this.meleeKillsByType = getIntArray(hex, 0x220, shipCount);
    this.combatKillsByType = getIntArray(hex, 0x380, shipCount);
    this.exercisePartialsByType = getIntArray(hex, 0x4e0, shipCount);
    this.meleePartialsByType = getIntArray(hex, 0x640, shipCount);
    this.combatPartialsByType = getIntArray(hex, 0x7a0, shipCount);
    this.exerciseAssistsByType = getIntArray(hex, 0x900, shipCount);
    this.meleeAssistsByType = getIntArray(hex, 0xa60, shipCount);
    this.combatAssistsByType = getIntArray(hex, 0xbc0, shipCount);

    this.hiddenCargoFound = getIntArray(hex, 0x117c, modeCount);
    this.lasersHit = getIntArray(hex, 0x1188, modeCount);
    this.lasersFired = getIntArray(hex, 0x1194, modeCount);
    this.warheadsHit = getIntArray(hex, 0x11a0, modeCount);
    this.warheadsFired = getIntArray(hex, 0x11ac, modeCount);
    this.craftLosses = getIntArray(hex, 0x11b8, modeCount);
    this.collisionLosses = getIntArray(hex, 0x11c4, modeCount);
    this.starshipLosses = getIntArray(hex, 0x11d0, modeCount);
    this.mineLosses = getIntArray(hex, 0x11dc, modeCount);

    let off = 0x1360;
    this.trainingMissions = [];
    for (let i = 0; i < 40; i++) {
      const miss: number[] = getIntArray(hex, off + i * 36, 9);
      this.trainingMissions.push(
        new XvTMission(miss[0], miss[1], miss[2], miss[3], miss[4], miss[5], miss[6], miss[7], miss[8])
      );
    }

    off = 0x2170;
    this.meleeMissions = [];
    for (let i = 0; i < missionCount; i++) {
      const miss: number[] = getIntArray(hex, off + i * 36, 9);
      this.meleeMissions.push(
        new XvTMission(miss[0], miss[1], miss[2], miss[3], miss[4], miss[5], miss[6], miss[7], miss[8])
      );
    }

    off = 0x4498;
    this.combatMissions = [];
    for (let i = 0; i < missionCount; i++) {
      const miss: number[] = getIntArray(hex, off + i * 36, 9);
      this.combatMissions.push(
        new XvTMission(miss[0], miss[1], miss[2], miss[3], miss[4], miss[5], miss[6], miss[7], miss[8])
      );
    }
  }

  public get BattleVictories(): TriStat[] {
    const victories: TriStat[] = [];
    for (let i = 0; i < shipCount; i++) {
      if (this.hasTypeKills(i)) {
        victories.push({
          Label: craft[i + 1],
          Exercise: `${this.exerciseKillsByType[i]} (${this.exercisePartialsByType[i]})`,
          Melee: `${this.meleeKillsByType[i]} (${this.meleePartialsByType[i]})`,
          Combat: `${this.combatKillsByType[i]} (${this.combatAssistsByType[i]})`
        });
      }
    }
    return victories;
  }

  public get LaserLabel(): TriStat {
    return {
      Label: "Lasers",
      Exercise: this.shootInfo(this.lasersHit[0], this.lasersFired[0]),
      Melee: this.shootInfo(this.lasersHit[1], this.lasersFired[1]),
      Combat: this.shootInfo(this.lasersHit[2], this.lasersFired[2])
    };
  }

  public get LaserPercent(): TriStat {
    return {
      Label: "",
      Exercise: this.percent(this.lasersHit[0], this.lasersFired[0]),
      Melee: this.percent(this.lasersHit[1], this.lasersFired[1]),
      Combat: this.percent(this.lasersHit[2], this.lasersFired[2])
    };
  }

  public get WarheadLabel(): TriStat {
    return {
      Label: "Warheads",
      Exercise: this.shootInfo(this.warheadsHit[0], this.warheadsFired[0]),
      Melee: this.shootInfo(this.warheadsHit[1], this.warheadsFired[1]),
      Combat: this.shootInfo(this.warheadsHit[2], this.warheadsFired[2])
    };
  }

  public get WarheadPercent(): TriStat {
    return {
      Label: "",
      Exercise: this.percent(this.warheadsHit[0], this.warheadsFired[0]),
      Melee: this.percent(this.warheadsHit[1], this.warheadsFired[1]),
      Combat: this.percent(this.warheadsHit[2], this.warheadsFired[2])
    };
  }

  public get MissionsFlown(): TriStat {
    return {
      Label: "Missions Flown",
      Exercise: this.playCounts[0],
      Melee: this.playCounts[1],
      Combat: this.playCounts[2]
    };
  }

  public get Kills(): TriStat {
    return {
      Label: "Kills",
      Exercise: this.kills[0],
      Melee: this.kills[1],
      Combat: this.kills[2]
    };
  }

  public get HiddenCargo(): TriStat {
    return {
      Label: "Hidden Cargo Found",
      Exercise: this.hiddenCargoFound[0],
      Melee: this.hiddenCargoFound[1],
      Combat: this.hiddenCargoFound[2]
    };
  }

  public get CraftLostStat(): TriStat {
    return {
      Label: "Craft Lost",
      Exercise: this.craftLosses[0],
      Melee: this.craftLosses[1],
      Combat: this.craftLosses[2]
    };
  }

  public get Collisions(): TriStat {
    return {
      Label: "Collisions",
      Exercise: this.collisionLosses[0],
      Melee: this.collisionLosses[1],
      Combat: this.collisionLosses[2]
    };
  }

  private hasTypeKills(type: number): boolean {
    const k: number =
      this.exerciseKillsByType[type] ||
      this.exercisePartialsByType[type] ||
      this.meleeKillsByType[type] ||
      this.meleePartialsByType[type] ||
      this.combatKillsByType[type] ||
      this.combatAssistsByType[type];
    return k > 0;
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit} / ${fired}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }
}

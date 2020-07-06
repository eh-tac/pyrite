import { PilotData, BattleSummary, KillSummary } from ".";
import { getChar, getInt, getIntArray } from "../hex";
import { XWAMission } from "./xwa-mission";
import { TriStat } from "./xvt-team-stats";

const craftString = `01	X-wing
02	Y-wing
03	A-wing
04	B-wing
05	TIE Fighter
06	TIE Interceptor
07	TIE Bomber
08	TIE Advanced
09	TIE Defender
0A	IRD Fighter
0B	Toscan Fighter
0C	Missile Boat
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
1F	Mole Miner
20	Bulk Freighter
21	Cargo Ferry
22	Modular Conveyor
23	*Container Transport
24	Medium Transport
25	Murrian Transport
26	Corellian Transport
27	Millenium Falcon
28	Corellian Corvette
29	Modified Corvette
2A	Nebulon-B Frigate
2B	Modified Frigate
2C	*C-3 Passenger Liner
2D	*Carrack Cruiser
2E	Strike Cruiser
2F	Escort Carrier
30	Dreadnaught
31	MC80a Cruiser
32	MC40a Light Cruiser
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
48	Satellite 3
49	*Satellite 4
4A	*Satellite 5
4B	Mine A
4C	Mine B
4D	Mine C
4E	Gun Emplacement
4F	*Mine 5
50	Probe A
51	Probe B
52	*Probe 3
53	Nav Buoy A
54	Nav Buoy B
55	Hyper Buoy
56	Asteroid Field
57	Planet
58	Rendezvous Buoy
59	Cargo Canister
5A	Shipyard
5B	Repair Yard
5C	*Modified Strike Cruiser
5D	Lancer Frigate
5E	Bulk Cruiser
5F	Assault Frigate
60	Corellian Gunship
61	Imperial Landing Craft
62	Assault Shuttle
63	Marauder Corvette
64	Star Galleon
65	Imperial Research Ship
66	Luxury Yacht 3000
67	Ferryboat Liner
68	Modified Action Transport
69	Mobquet Transport
6A	Xiytiar Transport
6B	Freight Transport/C
6C	Freight Transport/H
6D	Freight Transport/K
6E	YT-2000
6F	YT-2400
70	Suprosa
71	Skipray Blastboat
72	T/e m1
73	T/e m2
74	T/e m3
75	T/e m4
76	T/e m5
77	Cloakshape Fighter
78	Razor Fighter
79	Planetary Fighter
7A	Supa Fighter
7B	Pinook Fighter
7C	*Booster Pack
7D	Preybird Fighter
7E	*StarViper
7F	Firespray
80	Pursuer
81	Golan 1
82	Golan 2
83	Golan 3
84	Derilyn Platform
85	Sensor Array
86	Comm Relay
87	Space Colony 1
88	Space Colony 2
89	Space Colony 3
8A	Casino
8B	Cargo Facility 1
8C	Cargo Facility 2
8D	Asteroid Mining Plant
8E	Processing Plant
8F	Rebel Platform
90	Imperial Research Center
91	Family Base
92	Family Repair Yard
93	Pirate Shipyard
94	Industrical Complex
95	*Pirate Junkyard Base
96	Escape Pod 1
97	Pressure Tank
98	Container J
99	Container K
9A	Container L
9B	Container Hangar
9C	Large Gun Emplacement
9D	Large Gun/Warhead Emplacement
9E	Proximity Mine A
9F	Proximity Mine B
A0	*Homing Mine A
A1	Homing Mine B
A2	New Laser Battery
A3	New Ion Battery
A4	Cargo Freighter
A5	*Cargo Freighter 2
A6	*Cargo Freighter 3
A7	*Cargo Freighter 4
A8	*Cargo Freighter 5
A9	Cargo Tanker
AA	*Cargo Tanker 2
AB	*Cargo Tanker 3
AC	*Cargo Tanker 4
AD	*Cargo Tanker 5
AE	Escape Pod 2
AF	*Rebel Pilot
B0	*Imperial Pilot
B1	*Civilian Pilot
B2	Spacetrooper
B3	Zero-G Utility Suit
B4	Emkay
B5	Astromech
B6	Worker droid
B7	Backdrop
B8	*Forest Moon of Endor
B9	*Endor
BA	*Sullust
BB	*Bothuwai
BC	*Kothlis
BD	*Hoth
BE	*DeathStar II backdrop
BF	*Nar Shadda
C0	*Planet
C5	*Planet
C6	*Moon
CA	*Moon
CB	*Sun
D4	*Sun
D5	*Backdrop
E2	*Backdrop
E3	Death Star II
E4	MC80 Liberty-class Cruiser
E5	Victory-class Star Destroyer II
E6	Imperator-class Star Destroyer II
E7	*Planet`;
const craft: string[] = [];
craftString.split("\n").forEach(s => {
  const n = parseInt(s.substr(0, 2), 16);
  craft[n] = s.substr(3);
});
const missionCount = 100;
const shipCount = parseInt("E7", 16);

export class XWAPlt implements PilotData {
  public name: string;
  public totalScore: number;

  public todScore: number;
  public azzScore: number;
  public simScore: number;

  public todKills: number[] = [];
  public azzKills: number[] = [];
  public simKills: number[] = [];
  public todPartials: number[] = [];
  public azzPartials: number[] = [];
  public simPartials: number[] = [];

  public lasersHit: number;
  public lasersFired: number;
  public warheadsHit: number;
  public warheadsFired: number;
  public craftLost: number;

  public missions: XWAMission[] = [];

  public pilotRating: string;
  public currentRank: number;
  public currentMedal: number;
  public bonusTen: number;

  constructor(hex: ArrayBuffer) {
    this.name = getChar(hex, 0x0, 14);
    this.totalScore = getInt(hex, 0xe);

    this.todScore = getInt(hex, 0x9e);
    this.azzScore = getInt(hex, 0xa2);
    this.simScore = getInt(hex, 0xa6);

    for (let i = 1; i < 16; i++) {
      console.log("xwa unknown", getInt(hex, 0xa6 + i * 4));
    }

    const tkOff = 0xd2;
    const akOff = 0x8ce;
    const skOff = 0x10d2;
    const tpOff = 0x18d2;
    const apOff = 0x20ce;
    const spOff = 0x28d2;
    for (let i = 0; i < craft.length; i++) {
      this.todKills.push(getInt(hex, tkOff + i * 4));
      this.azzKills.push(getInt(hex, akOff + i * 4));
      this.simKills.push(getInt(hex, skOff + i * 4));
      this.todPartials.push(getInt(hex, tpOff + i * 4));
      this.azzPartials.push(getInt(hex, apOff + i * 4));
      this.simPartials.push(getInt(hex, spOff + i * 4));
    }

    this.lasersHit = getInt(hex, 0x4d36);
    this.lasersFired = getInt(hex, 0x4d42);
    this.warheadsHit = getInt(hex, 0x4d4e);
    this.warheadsFired = getInt(hex, 0x4d5a);
    this.craftLost = getInt(hex, 0x4d6e);

    const off = 0xad16 - 28;
    console.log(off, off.toString(16));
    for (let i = 0; i < missionCount; i++) {
      const n = off + i * 48;
      const arr: number[] = getIntArray(hex, n, 12);
      const m = new XWAMission(arr[1], arr[5], arr[7], arr[8], arr[11]);
      this.missions.push(m);
      if (i > 50 && i < 60) console.log(i, n.toString(16), m, arr);
    }

    this.pilotRating = getChar(hex, 0x0, 14);
    this.currentRank = getInt(hex, 0x10ea2);
    this.currentMedal = getInt(hex, 0x10ea6);
    this.bonusTen = getInt(hex, 0x1144e);
    console.log(this);

    // good for exploring the pilot file
    // let i = 0;
    // let n = off + i++ * 16 * 4;
    // while (n < hex.byteLength) {
    //   const a = getIntArray(hex, n, 16);
    //   if (a.some(x => x)) {
    //     console.log(n.toString(16), n, a);
    //   }
    //   n = off + i++ * 16 * 4;
    // }
  }

  public get total(): number {
    return this.totalScore + this.bonus;
  }

  public get bonus(): number {
    return this.bonusTen / 10;
  }

  public get LaserLabel(): string {
    return this.shootInfo(this.lasersHit, this.lasersFired);
  }

  public get LaserPercent(): string {
    return this.percent(this.lasersHit, this.lasersFired);
  }

  public get WarheadLabel(): string {
    return this.shootInfo(this.warheadsHit, this.warheadsFired);
  }

  public get WarheadPercent(): string {
    return this.percent(this.warheadsHit, this.warheadsFired);
  }

  public get BattleVictories(): TriStat[] {
    const victories: TriStat[] = [];
    for (let i = 0; i < shipCount; i++) {
      if (this.hasTypeKills(i)) {
        victories.push({
          Label: craft[i + 1],
          Exercise: `${this.todKills[i]} (${this.todPartials[i]})`,
          Melee: `${this.azzKills[i]} (${this.azzPartials[i]})`,
          Combat: `${this.simKills[i]} (${this.simPartials[i]})`
        });
      }
    }
    return victories;
  }

  private shootInfo(hit: number, fired: number): string {
    return `${hit} / ${fired}`;
  }

  private percent(hit: number, fired: number): string {
    const per = fired ? Math.floor((hit / fired) * 100) : 0;
    return `${per} %`;
  }

  private hasTypeKills(type: number): boolean {
    const k: number =
      this.todKills[type] ||
      this.todPartials[type] ||
      this.azzKills[type] ||
      this.azzPartials[type] ||
      this.simKills[type] ||
      this.simPartials[type];
    return k > 0;
  }
}

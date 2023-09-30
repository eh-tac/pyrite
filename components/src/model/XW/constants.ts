export class Constants {
  public static PILOTSTATUS = {
    0: "Normal",
    1: "Captured",
    2: "Killed",
  };

  public static PILOTRANK = {
    0: "Cadet",
    1: "Officer",
    2: "Lieutenant",
    3: "Captain",
    4: "Commander",
    5: "General",
  };

  public static KALIDORCRESCENT = {
    0: "None",
    1: "Kalidor Crescent",
    2: "Bronze Cluster",
    3: "Silver Talons",
    4: "Silver Scimitar",
    5: "Gold Wings",
    6: "Diamond Eyes",
  };

  public static TOURSTATUS = {
    0: "Inactive",
    1: "Active",
    2: "Incomplete",
    3: "Complete",
  };

  public static TOURMEDALS = {
    1: "Corellian Cross",
    2: "Mantooine Medallion",
    3: "Star Of Alderaan",
    4: "Shield Of Yavin",
    5: "Talons Of Hoth",
  };

  public static SHIPTYPE = {
    0: "X-Wing",
    1: "Y-Wing",
    2: "A-Wing",
    3: "TIE Fighter",
    4: "TIE Interceptor",
    5: "TIE Bomber",
    6: "Assault Gunboat",
    7: "Transport",
    8: "Shuttle",
    9: "Tug",
    10: "Container",
    11: "Freighter",
    12: "Calamari",
    13: "NebulonB",
    14: "Corvette",
    15: "Star Destroyer",
    16: "TIE Advanced",
    17: "Mine1",
    18: "Mine2",
    19: "Mine3",
    20: "Mine4",
    21: "CommSat1",
    22: "CommSat2",
    23: "Probe",
  };

  public static ENDSTATE = {
    0: "Rescued",
    1: "Captured",
    5: "Hit Exhaust Port",
  };

  public static MISSIONLOCATION = {
    0: "Deep Space",
    1: "Death Star",
  };

  public static CRAFTTYPE = {
    0: "None",
    1: "X-Wing",
    2: "Y-Wing",
    3: "A-Wing",
    4: "TIE Fighter",
    5: "TIE Interceptor",
    6: "TIE Bomber",
    7: "Assault Gunboat",
    8: "Transport",
    9: "Shuttle",
    10: "Tug",
    11: "Container",
    12: "Freighter",
    13: "Calamari Cruiser",
    14: "Nebulon B Frigate",
    15: "Corellian Corvette",
    16: "Imperial Star Destroyer",
    17: "TIE Advanced",
    18: "B-Wing",
  };

  public static IFF = {
    0: "Default",
    1: "Rebel",
    2: "Imperial",
    3: "Neutral",
  };

  public static FLIGHTGROUPSTATUS = {
    0: "Normal",
    1: "No Missiles",
    2: "Half Missiles",
    3: "No Shields",
  };

  public static ARRIVALEVENT = {
    0: "Mission Start",
    1: "On Arrival",
    2: "On Destroyed",
    3: "On Attacked",
    4: "On Boarded",
    5: "On Identified",
    6: "On Disabled",
  };

  public static FORMATION = {
    0: "Vic",
    1: "Finger Four",
    2: "Line Astern",
    3: "Line Abrest",
    4: "Echelon Right",
    5: "Echelon Left",
    6: "Double Astern",
    7: "Diamond",
    8: "Stacked",
    9: "Spread",
    16: "Hi-Lo",
    17: "Spiral",
  };

  public static CRAFTAI = {
    0: "Rookie",
    1: "Officer",
    2: "Veteran",
    3: "Ace",
    4: "Top Ace",
  };

  public static ORDER = {
    0: "Hold Steady",
    1: "Fly Home",
    2: "Circle and Ignore",
    3: "Fly Once and Ignore",
    4: "Circle and Evade",
    5: "Fly Once and Evade",
    6: "Close Escort",
    7: "Loose Escort",
    8: "Attack Escorts",
    9: "Attack Targets",
    10: "Attack Enemies",
    11: "Rendezous",
    12: "Disabled",
    13: "Board to Deliver",
    14: "Board to Take",
    15: "Board to Exchange",
    16: "Board to Capture",
    17: "Board to Destroy",
    18: "Disable Targets",
    19: "Disable All",
    20: "Attack Transports",
    21: "Attack Freighters",
    22: "Attack Starships",
    23: "Attack Satellites and Mines",
    24: "Disable Freighters",
    25: "Disable Starships",
    26: "Starship Static Fire",
    27: "Starship Fly Dance",
    28: "Starship Circle",
    29: "Starship Await Return",
    30: "Starship Await Launch",
    31: "Starship Await Boarding",
  };

  public static CRAFTCOLOUR = {
    0: "Red",
    1: "Gold",
    2: "Blue",
  };

  public static CRAFTOBJECTIVE = {
    0: "None",
    1: "All Destroyed",
    2: "All Survive",
    3: "All Captured",
    4: "All Docked",
    5: "Special Craft Destroyed",
    6: "Special Craft Survive",
    7: "Special Craft Captured",
    8: "Special Craft Docked",
    9: "Half Destroyed",
    10: "Half Survive",
    11: "Half Captured",
    12: "Half Docked",
    13: "All Identified",
    14: "Special Craft Identified",
    15: "Half Identified",
    16: "Arrived",
  };

  public static OBJECTOBJECTIVE = {
    3: "None",
    4: "Destroy",
    5: "Survive",
  };

}

export enum PilotStatus {
  normal = 0,
  captured = 1,
  killed = 2,
}

export enum PilotRank {
  cadet = 0,
  officer = 1,
  lieutenant = 2,
  captain = 3,
  commander = 4,
  general = 5,
}

export enum KalidorCrescent {
  none = 0,
  kalidorCrescent = 1,
  bronzeCluster = 2,
  silverTalons = 3,
  silverScimitar = 4,
  goldWings = 5,
  diamondEyes = 6,
}

export enum TourStatus {
  inactive = 0,
  active = 1,
  incomplete = 2,
  complete = 3,
}

export enum TourMedals {
  corellianCross = 1,
  mantooineMedallion = 2,
  starOfAlderaan = 3,
  shieldOfYavin = 4,
  talonsOfHoth = 5,
}

export enum ShipType {
  xWing = 0,
  yWing = 1,
  aWing = 2,
  tieFighter = 3,
  tieInterceptor = 4,
  tieBomber = 5,
  assaultGunboat = 6,
  transport = 7,
  shuttle = 8,
  tug = 9,
  container = 10,
  freighter = 11,
  calamari = 12,
  nebulonB = 13,
  corvette = 14,
  starDestroyer = 15,
  tieAdvanced = 16,
  mine1 = 17,
  mine2 = 18,
  mine3 = 19,
  mine4 = 20,
  commSat1 = 21,
  commSat2 = 22,
  probe = 23,
}

export enum EndState {
  rescued = 0,
  captured = 1,
  hitExhaustPort = 5,
}

export enum MissionLocation {
  deepSpace = 0,
  deathStar = 1,
}

export enum CraftType {
  none = 0,
  xWing = 1,
  yWing = 2,
  aWing = 3,
  tieFighter = 4,
  tieInterceptor = 5,
  tieBomber = 6,
  assaultGunboat = 7,
  transport = 8,
  shuttle = 9,
  tug = 10,
  container = 11,
  freighter = 12,
  calamariCruiser = 13,
  nebulonBFrigate = 14,
  corellianCorvette = 15,
  imperialStarDestroyer = 16,
  tieAdvanced = 17,
  bWing = 18,
}

export enum IFF {
  default = 0,
  rebel = 1,
  imperial = 2,
  neutral = 3,
}

export enum FlightGroupStatus {
  normal = 0,
  noMissiles = 1,
  halfMissiles = 2,
  noShields = 3,
}

export enum ArrivalEvent {
  missionStart = 0,
  onArrival = 1,
  onDestroyed = 2,
  onAttacked = 3,
  onBoarded = 4,
  onIdentified = 5,
  onDisabled = 6,
}

export enum Formation {
  vic = 0,
  fingerFour = 1,
  lineAstern = 2,
  lineAbrest = 3,
  echelonRight = 4,
  echelonLeft = 5,
  doubleAstern = 6,
  diamond = 7,
  stacked = 8,
  spread = 9,
  hiLo = 16,
  spiral = 17,
}

export enum CraftAI {
  rookie = 0,
  officer = 1,
  veteran = 2,
  ace = 3,
  topAce = 4,
}

export enum Order {
  holdSteady = 0,
  flyHome = 1,
  circleAndIgnore = 2,
  flyOnceAndIgnore = 3,
  circleAndEvade = 4,
  flyOnceAndEvade = 5,
  closeEscort = 6,
  looseEscort = 7,
  attackEscorts = 8,
  attackTargets = 9,
  attackEnemies = 10,
  rendezous = 11,
  disabled = 12,
  boardToDeliver = 13,
  boardToTake = 14,
  boardToExchange = 15,
  boardToCapture = 16,
  boardToDestroy = 17,
  disableTargets = 18,
  disableAll = 19,
  attackTransports = 20,
  attackFreighters = 21,
  attackStarships = 22,
  attackSatellitesAndMines = 23,
  disableFreighters = 24,
  disableStarships = 25,
  starshipStaticFire = 26,
  starshipFlyDance = 27,
  starshipCircle = 28,
  starshipAwaitReturn = 29,
  starshipAwaitLaunch = 30,
  starshipAwaitBoarding = 31,
}

export enum CraftColour {
  red = 0,
  gold = 1,
  blue = 2,
}

export enum CraftObjective {
  none = 0,
  allDestroyed = 1,
  allSurvive = 2,
  allCaptured = 3,
  allDocked = 4,
  specialCraftDestroyed = 5,
  specialCraftSurvive = 6,
  specialCraftCaptured = 7,
  specialCraftDocked = 8,
  halfDestroyed = 9,
  halfSurvive = 10,
  halfCaptured = 11,
  halfDocked = 12,
  allIdentified = 13,
  specialCraftIdentified = 14,
  halfIdentified = 15,
  arrived = 16,
}

export enum ObjectObjective {
  none = 3,
  destroy = 4,
  survive = 5,
}

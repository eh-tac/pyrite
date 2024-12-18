<?php

namespace Pyrite\XvT;

class Constants
{
    public static $DESIGNATION = [
        0 => "None",
        1 => "Base",
        2 => "Command Ship",
        3 => "Convoy Craft",
        4 => "Manufacturing Facility",
        5 => "Mission Critical Craft",
        6 => "Primary Target",
        7 => "Reload Craft",
        8 => "Resource Center",
        9 => "Secondary Target",
        10 => "Station",
        11 => "Strike Craft",
        12 => "Tertiary Target",
    ];

    public static $DESIGNATION_NONE = 0;
    public static $DESIGNATION_BASE = 1;
    public static $DESIGNATION_COMMANDSHIP = 2;
    public static $DESIGNATION_CONVOYCRAFT = 3;
    public static $DESIGNATION_MANUFACTURINGFACILITY = 4;
    public static $DESIGNATION_MISSIONCRITICALCRAFT = 5;
    public static $DESIGNATION_PRIMARYTARGET = 6;
    public static $DESIGNATION_RELOADCRAFT = 7;
    public static $DESIGNATION_RESOURCECENTER = 8;
    public static $DESIGNATION_SECONDARYTARGET = 9;
    public static $DESIGNATION_STATION = 10;
    public static $DESIGNATION_STRIKECRAFT = 11;
    public static $DESIGNATION_TERTIARYTARGET = 12;

    public static $SHIPS = [
        0 => "Unknown",
        1 => "X-Wing",
        2 => "Y-Wing",
        3 => "A-Wing",
        4 => "*B-Wing",
        5 => "TIE Fighter",
        6 => "TIE Interceptor",
        7 => "TIE Bomber",
        8 => "TIE Advanced",
        9 => "*TIE Defender",
        10 => "Patch Slot 10",
        11 => "Patch Slot 11",
        12 => "Missile Boat",
        13 => "T-Wing",
        14 => "Z-95 Headhunter",
        15 => "R-41 Starchaser",
        16 => "Assault Gunboat",
        17 => "Shuttle",
        18 => "Escort Shuttle",
        19 => "System Patrol Craft",
        20 => "*Scout Craft",
        21 => "Stormtrooper Transport",
        22 => "Assault Transport",
        23 => "Escort Transport",
        24 => "Utility Tug",
        25 => "Combat Utility Vehicle",
        26 => "Container Class A",
        27 => "Container Class B",
        28 => "Container Class C",
        29 => "Container Class D",
        30 => "Heavy Lifter",
        31 => "*bulk_barge2",
        32 => "Bulk Freighter",
        33 => "Cargo Ferry",
        34 => "Modular Conveyor",
        35 => "Container Transport",
        36 => "*new_freighter3",
        37 => "Muurian Transport",
        38 => "Corellian Transport",
        39 => "*Millenium",
        40 => "Corellian Corvette",
        41 => "*Modified Corvette",
        42 => "Nebulon B Frigate",
        43 => "*Modified Frigate",
        44 => "*Passenger Liner",
        45 => "*Carrack Cruiser",
        46 => "Strike Cruiser",
        47 => "Escort Carrier",
        48 => "Dreadnaught",
        49 => "Calamari Cruiser",
        50 => "Lt. Calamari Cruiser",
        51 => "Interdictor",
        52 => "Victory Star Destroyer",
        53 => "Imperial Star Destroyer",
        54 => "*super_sd",
        55 => "Container Class E",
        56 => "Container Class F",
        57 => "Container Class G",
        58 => "Container Class H",
        59 => "Container Class I",
        60 => "XQ1 Platform",
        61 => "XQ2 Platform",
        62 => "XQ3 Platform",
        63 => "XQ4 Platform",
        64 => "XQ5 Platform",
        65 => "XQ6 Platform",
        66 => "Asteroid Hangar",
        67 => "Asteroid Laser Battery",
        68 => "Asteroid War Launcher",
        69 => "X7 Factory",
        70 => "Comm Sat",
        71 => "Comm Sat",
        72 => "*Sat3",
        73 => "*Sat4",
        74 => "*Sat5",
        75 => "Mine Type A",
        76 => "Mine Type B",
        77 => "Mine Type C",
        78 => "*Mine4",
        79 => "*Mine5",
        80 => "Probe",
        81 => "*Probe2",
        82 => "*Probe3",
        83 => "Nav Buoy",
        84 => "Nav Buoy",
        85 => "*Pilot",
        86 => "Asteroid",
        87 => "Planet",
        88 => "Obstacle",
        89 => "Unused",
        90 => "Shipyard",
        91 => "Repair Yard",
        92 => "Modified Strike Cruiser",
    ];

    public static $SHIPS_UNKNOWN = 0;
    public static $SHIPS_XWING = 1;
    public static $SHIPS_YWING = 2;
    public static $SHIPS_AWING = 3;
    public static $SHIPS_BWING = 4;
    public static $SHIPS_TIEFIGHTER = 5;
    public static $SHIPS_TIEINTERCEPTOR = 6;
    public static $SHIPS_TIEBOMBER = 7;
    public static $SHIPS_TIEADVANCED = 8;
    public static $SHIPS_TIEDEFENDER = 9;
    public static $SHIPS_PATCHSLOT10 = 10;
    public static $SHIPS_PATCHSLOT11 = 11;
    public static $SHIPS_MISSILEBOAT = 12;
    public static $SHIPS_TWING = 13;
    public static $SHIPS_Z95HEADHUNTER = 14;
    public static $SHIPS_R41STARCHASER = 15;
    public static $SHIPS_ASSAULTGUNBOAT = 16;
    public static $SHIPS_SHUTTLE = 17;
    public static $SHIPS_ESCORTSHUTTLE = 18;
    public static $SHIPS_SYSTEMPATROLCRAFT = 19;
    public static $SHIPS_SCOUTCRAFT = 20;
    public static $SHIPS_STORMTROOPERTRANSPORT = 21;
    public static $SHIPS_ASSAULTTRANSPORT = 22;
    public static $SHIPS_ESCORTTRANSPORT = 23;
    public static $SHIPS_UTILITYTUG = 24;
    public static $SHIPS_COMBATUTILITYVEHICLE = 25;
    public static $SHIPS_CONTAINERCLASSA = 26;
    public static $SHIPS_CONTAINERCLASSB = 27;
    public static $SHIPS_CONTAINERCLASSC = 28;
    public static $SHIPS_CONTAINERCLASSD = 29;
    public static $SHIPS_HEAVYLIFTER = 30;
    public static $SHIPS_BULKBARGE2 = 31;
    public static $SHIPS_BULKFREIGHTER = 32;
    public static $SHIPS_CARGOFERRY = 33;
    public static $SHIPS_MODULARCONVEYOR = 34;
    public static $SHIPS_CONTAINERTRANSPORT = 35;
    public static $SHIPS_NEWFREIGHTER3 = 36;
    public static $SHIPS_MUURIANTRANSPORT = 37;
    public static $SHIPS_CORELLIANTRANSPORT = 38;
    public static $SHIPS_MILLENIUM = 39;
    public static $SHIPS_CORELLIANCORVETTE = 40;
    public static $SHIPS_MODIFIEDCORVETTE = 41;
    public static $SHIPS_NEBULONBFRIGATE = 42;
    public static $SHIPS_MODIFIEDFRIGATE = 43;
    public static $SHIPS_PASSENGERLINER = 44;
    public static $SHIPS_CARRACKCRUISER = 45;
    public static $SHIPS_STRIKECRUISER = 46;
    public static $SHIPS_ESCORTCARRIER = 47;
    public static $SHIPS_DREADNAUGHT = 48;
    public static $SHIPS_CALAMARICRUISER = 49;
    public static $SHIPS_LTCALAMARICRUISER = 50;
    public static $SHIPS_INTERDICTOR = 51;
    public static $SHIPS_VICTORYSTARDESTROYER = 52;
    public static $SHIPS_IMPERIALSTARDESTROYER = 53;
    public static $SHIPS_SUPERSD = 54;
    public static $SHIPS_CONTAINERCLASSE = 55;
    public static $SHIPS_CONTAINERCLASSF = 56;
    public static $SHIPS_CONTAINERCLASSG = 57;
    public static $SHIPS_CONTAINERCLASSH = 58;
    public static $SHIPS_CONTAINERCLASSI = 59;
    public static $SHIPS_XQ1PLATFORM = 60;
    public static $SHIPS_XQ2PLATFORM = 61;
    public static $SHIPS_XQ3PLATFORM = 62;
    public static $SHIPS_XQ4PLATFORM = 63;
    public static $SHIPS_XQ5PLATFORM = 64;
    public static $SHIPS_XQ6PLATFORM = 65;
    public static $SHIPS_ASTEROIDHANGAR = 66;
    public static $SHIPS_ASTEROIDLASERBATTERY = 67;
    public static $SHIPS_ASTEROIDWARLAUNCHER = 68;
    public static $SHIPS_X7FACTORY = 69;
    public static $SHIPS_COMMSAT = 70;
    public static $SHIPS_COMMSAT2 = 71;
    public static $SHIPS_SAT3 = 72;
    public static $SHIPS_SAT4 = 73;
    public static $SHIPS_SAT5 = 74;
    public static $SHIPS_MINETYPEA = 75;
    public static $SHIPS_MINETYPEB = 76;
    public static $SHIPS_MINETYPEC = 77;
    public static $SHIPS_MINE4 = 78;
    public static $SHIPS_MINE5 = 79;
    public static $SHIPS_PROBE = 80;
    public static $SHIPS_PROBE2 = 81;
    public static $SHIPS_PROBE3 = 82;
    public static $SHIPS_NAVBUOY = 83;
    public static $SHIPS_NAVBUOY2 = 84;
    public static $SHIPS_PILOT = 85;
    public static $SHIPS_ASTEROID = 86;
    public static $SHIPS_PLANET = 87;
    public static $SHIPS_OBSTACLE = 88;
    public static $SHIPS_UNUSED = 89;
    public static $SHIPS_SHIPYARD = 90;
    public static $SHIPS_REPAIRYARD = 91;
    public static $SHIPS_MODIFIEDSTRIKECRUISER = 92;

    public static $PILOTRATING = [
        0 => "Target Drone",
        1 => "Ground Crew",
        2 => "Trainee",
        3 => "Flight Cadet",
        4 => "Officer 4th Class",
        5 => "Officer 3rd Class",
        6 => "Officer 2nd Class",
        7 => "Officer 1st Class",
        8 => "Veteran 4th Grade",
        9 => "Veteran 3rd Grade",
        10 => "Veteran 2nd Grade",
        11 => "Veteran 1st Grade",
        12 => "Ace 4th Level",
        13 => "Ace 3rd Level",
        14 => "Ace 2nd Level",
        15 => "Ace 1st Level",
        16 => "Top Ace 4th Order",
        17 => "Top Ace 3rd Order",
        18 => "Top Ace 2nd Order",
        19 => "Top Ace 1st Order",
        20 => "Jedi 4th Degree",
        21 => "Jedi 3rd Degree",
        22 => "Jedi 2nd Degree",
        23 => "Jedi 1st Degree",
        24 => "Jedi Master",
    ];

    public static $PILOTRATING_TARGETDRONE = 0;
    public static $PILOTRATING_GROUNDCREW = 1;
    public static $PILOTRATING_TRAINEE = 2;
    public static $PILOTRATING_FLIGHTCADET = 3;
    public static $PILOTRATING_OFFICER4THCLASS = 4;
    public static $PILOTRATING_OFFICER3RDCLASS = 5;
    public static $PILOTRATING_OFFICER2NDCLASS = 6;
    public static $PILOTRATING_OFFICER1STCLASS = 7;
    public static $PILOTRATING_VETERAN4THGRADE = 8;
    public static $PILOTRATING_VETERAN3RDGRADE = 9;
    public static $PILOTRATING_VETERAN2NDGRADE = 10;
    public static $PILOTRATING_VETERAN1STGRADE = 11;
    public static $PILOTRATING_ACE4THLEVEL = 12;
    public static $PILOTRATING_ACE3RDLEVEL = 13;
    public static $PILOTRATING_ACE2NDLEVEL = 14;
    public static $PILOTRATING_ACE1STLEVEL = 15;
    public static $PILOTRATING_TOPACE4THORDER = 16;
    public static $PILOTRATING_TOPACE3RDORDER = 17;
    public static $PILOTRATING_TOPACE2NDORDER = 18;
    public static $PILOTRATING_TOPACE1STORDER = 19;
    public static $PILOTRATING_JEDI4THDEGREE = 20;
    public static $PILOTRATING_JEDI3RDDEGREE = 21;
    public static $PILOTRATING_JEDI2NDDEGREE = 22;
    public static $PILOTRATING_JEDI1STDEGREE = 23;
    public static $PILOTRATING_JEDIMASTER = 24;

    public static $WARHEAD = [
        0 => "None",
        1 => "Space Bomb",
        2 => "Heavy Rocket",
        3 => "Concussion Missile",
        4 => "Torpedo",
        5 => "Advanced Concussion Missile",
        6 => "Advanced Torpedo",
        7 => "Mag Pulse Torpedo",
        8 => "(Ion Pulse)",
    ];

    public static $WARHEAD_NONE = 0;
    public static $WARHEAD_SPACEBOMB = 1;
    public static $WARHEAD_HEAVYROCKET = 2;
    public static $WARHEAD_CONCUSSIONMISSILE = 3;
    public static $WARHEAD_TORPEDO = 4;
    public static $WARHEAD_ADVANCEDCONCUSSIONMISSILE = 5;
    public static $WARHEAD_ADVANCEDTORPEDO = 6;
    public static $WARHEAD_MAGPULSETORPEDO = 7;
    public static $WARHEAD_IONPULSE = 8;

    public static $BEAM = [
        0 => "None",
        1 => "Tractor Beam",
        2 => "Jamming Beam",
        3 => "Decoy Beam",
        4 => "Energy Beam"
    ];

    public static $BEAM_NONE = 0;
    public static $BEAM_TRACTORBEAM = 1;
    public static $BEAM_JAMMINGBEAM = 2;
    public static $BEAM_DECOYBEAM = 3;
    public static $BEAM_ENERGYBEAM = 4;

    public static $COUNTERMEASURES = [
        0 => "None",
        1 => "Chaff",
        2 => "Flare",
        3 => "(Cluster Mine)",
    ];

    public static $COUNTERMEASURES_NONE = 0;
    public static $COUNTERMEASURES_CHAFF = 1;
    public static $COUNTERMEASURES_FLARE = 2;
    public static $COUNTERMEASURES_CLUSTERMINE = 3;

    public static $BESTRATING = [
        0 => "Gold",
        1 => "Silver",
        2 => "Bronze",
        3 => "Nickel",
        4 => "Copper",
        5 => "Lead",
    ];

    public static $BESTRATING_GOLD = 0;
    public static $BESTRATING_SILVER = 1;
    public static $BESTRATING_BRONZE = 2;
    public static $BESTRATING_NICKEL = 3;
    public static $BESTRATING_COPPER = 4;
    public static $BESTRATING_LEAD = 5;

    public static $STATUS = [
        0 => "None",
        1 => "2X Warheads",
        2 => "1/2 Warheads",
        3 => "Disabled",
        4 => "1/2 Shields",
        5 => "No Lasers",
        6 => "No Hyperdrive",
        7 => "Shields 0%, charging",
        8 => "Shields added or 200%",
        9 => "Hyperdrive added",
        10 => "Unknown",
        11 => "Unknown",
        12 => "(200% Shields)",
        13 => "Shields 50%, Charging",
        14 => "(No Lasers)",
        15 => "Unknown",
        16 => "Shields + Hyperdrive added",
        17 => "Unknown",
        18 => "200% Shields",
        19 => "(50% Shields)",
        20 => "Invincible",
        21 => "Infinite Warheads",
    ];

    public static $STATUS_NONE = 0;
    public static $STATUS_N2XWARHEADS = 1;
    public static $STATUS_N12WARHEADS = 2;
    public static $STATUS_DISABLED = 3;
    public static $STATUS_N12SHIELDS = 4;
    public static $STATUS_NOLASERS = 5;
    public static $STATUS_NOHYPERDRIVE = 6;
    public static $STATUS_SHIELDS0PERCENTCHARGING = 7;
    public static $STATUS_SHIELDSADDEDOR200PERCENT = 8;
    public static $STATUS_HYPERDRIVEADDED = 9;
    public static $STATUS_UNKNOWN = 10;
    public static $STATUS_UNKNOWN2 = 11;
    public static $STATUS_N200PERCENTSHIELDS = 12;
    public static $STATUS_SHIELDS50PERCENTCHARGING = 13;
    public static $STATUS_NOLASERS2 = 14;
    public static $STATUS_UNKNOWN3 = 15;
    public static $STATUS_SHIELDSHYPERDRIVEADDED = 16;
    public static $STATUS_UNKNOWN4 = 17;
    public static $STATUS_N200PERCENTSHIELDS2 = 18;
    public static $STATUS_N50PERCENTSHIELDS = 19;
    public static $STATUS_INVINCIBLE = 20;
    public static $STATUS_INFINITEWARHEADS = 21;

    public static $GROUPAI = [
        0 => "Rookie (None)",
        1 => "Officer",
        2 => "Veteran",
        3 => "Ace",
        4 => "Top Ace",
        5 => "Jedi (Invincible)",
    ];

    public static $GROUPAI_ROOKIENONE = 0;
    public static $GROUPAI_OFFICER = 1;
    public static $GROUPAI_VETERAN = 2;
    public static $GROUPAI_ACE = 3;
    public static $GROUPAI_TOPACE = 4;
    public static $GROUPAI_JEDIINVINCIBLE = 5;

    public static $MARKINGS = [
        0 => "Red (TIE - None)",
        1 => "Gold (TIE - Red)",
        2 => "Blue (TIE - Gold)",
        3 => "Green (TIE - Blue)",
    ];

    public static $MARKINGS_REDTIENONE = 0;
    public static $MARKINGS_GOLDTIERED = 1;
    public static $MARKINGS_BLUETIEGOLD = 2;
    public static $MARKINGS_GREENTIEBLUE = 3;

    public static $RADIO = [
        0 => "None",
        1 => "Team 1 (Imperial)",
        2 => "Team 2 (Rebel)",
        3 => "Team 3",
        4 => "Team 4",
        5 => "Team 5",
        6 => "Team 6",
        7 => "Team 7",
        8 => "Team 8",
        9 => "Player 1",
        10 => "Player 2",
        11 => "Player 3",
        12 => "Player 4",
        13 => "Player 5",
        14 => "Player 6",
        15 => "Player 7",
        16 => "Player 8",
    ];

    public static $RADIO_NONE = 0;
    public static $RADIO_TEAM1IMPERIAL = 1;
    public static $RADIO_TEAM2REBEL = 2;
    public static $RADIO_TEAM3 = 3;
    public static $RADIO_TEAM4 = 4;
    public static $RADIO_TEAM5 = 5;
    public static $RADIO_TEAM6 = 6;
    public static $RADIO_TEAM7 = 7;
    public static $RADIO_TEAM8 = 8;
    public static $RADIO_PLAYER1 = 9;
    public static $RADIO_PLAYER2 = 10;
    public static $RADIO_PLAYER3 = 11;
    public static $RADIO_PLAYER4 = 12;
    public static $RADIO_PLAYER5 = 13;
    public static $RADIO_PLAYER6 = 14;
    public static $RADIO_PLAYER7 = 15;
    public static $RADIO_PLAYER8 = 16;

    public static $FORMATION = [
        0 => "Vic",
        1 => "Finger Four",
        2 => "Line Astern",
        3 => "Line Abreast",
        4 => "Echelon Right",
        5 => "Echelon Left",
        6 => "Double Astern",
        7 => "Diamond",
        8 => "Stack",
        9 => "High X",
        10 => "Vic Abreast",
        11 => "High Vic",
        12 => "Reverse High Vic",
        13 => "Reverse Line Astern",
        14 => "Stacked Low",
        15 => "Abreast Right",
        16 => "Abreast Left",
        17 => "Wing Forward",
        18 => "Wing Back",
        19 => "Line Astern Up",
        20 => "Line Astern Down",
        21 => "Abreast V",
        22 => "Abreast Inverted V",
        23 => "Double Astern Mirror",
        24 => "Double Stacked Astern",
        25 => "Double Stacked High",
        26 => "Diamond 1",
        27 => "Diamond 2",
        28 => "Flat Pentagon",
        29 => "Side Pentagon",
        30 => "Front Pentagon",
        31 => "Flat Hexagon",
        32 => "Side Hexagon",
        33 => "Front Hexagon",
        34 => "Single Point",
    ];

    public static $FORMATION_VIC = 0;
    public static $FORMATION_FINGERFOUR = 1;
    public static $FORMATION_LINEASTERN = 2;
    public static $FORMATION_LINEABREAST = 3;
    public static $FORMATION_ECHELONRIGHT = 4;
    public static $FORMATION_ECHELONLEFT = 5;
    public static $FORMATION_DOUBLEASTERN = 6;
    public static $FORMATION_DIAMOND = 7;
    public static $FORMATION_STACK = 8;
    public static $FORMATION_HIGHX = 9;
    public static $FORMATION_VICABREAST = 10;
    public static $FORMATION_HIGHVIC = 11;
    public static $FORMATION_REVERSEHIGHVIC = 12;
    public static $FORMATION_REVERSELINEASTERN = 13;
    public static $FORMATION_STACKEDLOW = 14;
    public static $FORMATION_ABREASTRIGHT = 15;
    public static $FORMATION_ABREASTLEFT = 16;
    public static $FORMATION_WINGFORWARD = 17;
    public static $FORMATION_WINGBACK = 18;
    public static $FORMATION_LINEASTERNUP = 19;
    public static $FORMATION_LINEASTERNDOWN = 20;
    public static $FORMATION_ABREASTV = 21;
    public static $FORMATION_ABREASTINVERTEDV = 22;
    public static $FORMATION_DOUBLEASTERNMIRROR = 23;
    public static $FORMATION_DOUBLESTACKEDASTERN = 24;
    public static $FORMATION_DOUBLESTACKEDHIGH = 25;
    public static $FORMATION_DIAMOND1 = 26;
    public static $FORMATION_DIAMOND2 = 27;
    public static $FORMATION_FLATPENTAGON = 28;
    public static $FORMATION_SIDEPENTAGON = 29;
    public static $FORMATION_FRONTPENTAGON = 30;
    public static $FORMATION_FLATHEXAGON = 31;
    public static $FORMATION_SIDEHEXAGON = 32;
    public static $FORMATION_FRONTHEXAGON = 33;
    public static $FORMATION_SINGLEPOINT = 34;

    public static $ARRIVALDIFFICULTY = [
        0 => "All",
        1 => "Easy",
        2 => "Medium",
        3 => "Hard",
        4 => "Medium, Hard",
        5 => "Easy, Medium",
        6 => "Never",
        7 => "Never",
        8 => "Easy",
        9 => "Medium",
        10 => "Hard",
    ];

    public static $ARRIVALDIFFICULTY_ALL = 0;
    public static $ARRIVALDIFFICULTY_EASY = 1;
    public static $ARRIVALDIFFICULTY_MEDIUM = 2;
    public static $ARRIVALDIFFICULTY_HARD = 3;
    public static $ARRIVALDIFFICULTY_MEDIUMHARD = 4;
    public static $ARRIVALDIFFICULTY_EASYMEDIUM = 5;
    public static $ARRIVALDIFFICULTY_NEVER = 6;
    public static $ARRIVALDIFFICULTY_NEVER2 = 7;
    public static $ARRIVALDIFFICULTY_EASY2 = 8;
    public static $ARRIVALDIFFICULTY_MEDIUM2 = 9;
    public static $ARRIVALDIFFICULTY_HARD2 = 10;

    public static $CONDITION = [
        0 => "Always (true)",
        1 => "Created",
        2 => "Destroyed",
        3 => "Attacked",
        4 => "Captured",
        5 => "Inspected",
        6 => "Boarded",
        7 => "Docked",
        8 => "Disabled",
        9 => "Survived (exist)",
        10 => "None (false)",
        11 => "Unknown (---)",
        12 => "Completed mission",
        13 => "Completed Primary Goals",
        14 => "Failed Primary Goals",
        15 => "Completed Secondary Goals",
        16 => "Failed Secondary Goals",
        17 => "Completed Bonus Goals",
        18 => "Failed Bonus Goals",
        19 => "Dropped off",
        20 => "Reinforced",
        21 => "0% Shields",
        22 => "50% Hull",
        23 => "Out of Warheads",
        24 => "Unknown (arrive?)",
        25 => "be dropped off",
        26 => "destroyed in 1 hit",
        27 => "NOT be disabled",
        28 => "NOT be picked up",
        29 => "destroyed w/o Inspection",
        30 => "be docked with",
        31 => "NOT be docked with",
        32 => "begin boarding",
        33 => "NOT begin boarding",
        34 => "50% Shields",
        35 => "25% Shields",
        36 => "75% Hull",
        37 => "25% Hull",
        38 => "Unknown",
        39 => "Unknown",
        40 => "Unknown",
        41 => "be all Player Craft",
        42 => "reinforced by AI?",
        43 => "come and go",
        44 => "be picked up",
        45 => "withdraw",
        46 => "be carried away",
    ];

    public static $CONDITION_ALWAYSTRUE = 0;
    public static $CONDITION_CREATED = 1;
    public static $CONDITION_DESTROYED = 2;
    public static $CONDITION_ATTACKED = 3;
    public static $CONDITION_CAPTURED = 4;
    public static $CONDITION_INSPECTED = 5;
    public static $CONDITION_BOARDED = 6;
    public static $CONDITION_DOCKED = 7;
    public static $CONDITION_DISABLED = 8;
    public static $CONDITION_SURVIVEDEXIST = 9;
    public static $CONDITION_NONEFALSE = 10;
    public static $CONDITION_UNKNOWN = 11;
    public static $CONDITION_COMPLETEDMISSION = 12;
    public static $CONDITION_COMPLETEDPRIMARYGOALS = 13;
    public static $CONDITION_FAILEDPRIMARYGOALS = 14;
    public static $CONDITION_COMPLETEDSECONDARYGOALS = 15;
    public static $CONDITION_FAILEDSECONDARYGOALS = 16;
    public static $CONDITION_COMPLETEDBONUSGOALS = 17;
    public static $CONDITION_FAILEDBONUSGOALS = 18;
    public static $CONDITION_DROPPEDOFF = 19;
    public static $CONDITION_REINFORCED = 20;
    public static $CONDITION_N0PERCENTSHIELDS = 21;
    public static $CONDITION_N50PERCENTHULL = 22;
    public static $CONDITION_OUTOFWARHEADS = 23;
    public static $CONDITION_UNKNOWNARRIVE = 24;
    public static $CONDITION_BEDROPPEDOFF = 25;
    public static $CONDITION_DESTROYEDIN1HIT = 26;
    public static $CONDITION_NOTBEDISABLED = 27;
    public static $CONDITION_NOTBEPICKEDUP = 28;
    public static $CONDITION_DESTROYEDWOINSPECTION = 29;
    public static $CONDITION_BEDOCKEDWITH = 30;
    public static $CONDITION_NOTBEDOCKEDWITH = 31;
    public static $CONDITION_BEGINBOARDING = 32;
    public static $CONDITION_NOTBEGINBOARDING = 33;
    public static $CONDITION_N50PERCENTSHIELDS = 34;
    public static $CONDITION_N25PERCENTSHIELDS = 35;
    public static $CONDITION_N75PERCENTHULL = 36;
    public static $CONDITION_N25PERCENTHULL = 37;
    public static $CONDITION_UNKNOWN2 = 38;
    public static $CONDITION_UNKNOWN3 = 39;
    public static $CONDITION_UNKNOWN4 = 40;
    public static $CONDITION_BEALLPLAYERCRAFT = 41;
    public static $CONDITION_REINFORCEDBYAI = 42;
    public static $CONDITION_COMEANDGO = 43;
    public static $CONDITION_BEPICKEDUP = 44;
    public static $CONDITION_WITHDRAW = 45;
    public static $CONDITION_BECARRIEDAWAY = 46;

    public static $VARIABLETYPE = [
        0 => "None",
        1 => "Flight Group",
        2 => "CraftType (enum)",
        3 => "CraftCategory (enum)",
        4 => "ObjectCategory (enum)",
        5 => "IFF",
        6 => "Order (enum)",
        7 => "CraftWhen (enum)",
        8 => "Global Group",
        12 => "Team",
        21 => "All Teams except",
        23 => "Global Unit",
    ];

    public static $VARIABLETYPE_NONE = 0;
    public static $VARIABLETYPE_FLIGHTGROUP = 1;
    public static $VARIABLETYPE_CRAFTTYPEENUM = 2;
    public static $VARIABLETYPE_CRAFTCATEGORYENUM = 3;
    public static $VARIABLETYPE_OBJECTCATEGORYENUM = 4;
    public static $VARIABLETYPE_IFF = 5;
    public static $VARIABLETYPE_ORDERENUM = 6;
    public static $VARIABLETYPE_CRAFTWHENENUM = 7;
    public static $VARIABLETYPE_GLOBALGROUP = 8;
    public static $VARIABLETYPE_TEAM = 12;
    public static $VARIABLETYPE_ALLTEAMSEXCEPT = 21;
    public static $VARIABLETYPE_GLOBALUNIT = 23;

    public static $CRAFTCATEGORY = [
        0 => "Starfighters",
        1 => "Transports",
        2 => "Freighters/Containers",
        3 => "Starships",
        4 => "Utility Craft",
        5 => "Platforms/Facilities",
        6 => "Mines",
    ];

    public static $CRAFTCATEGORY_STARFIGHTERS = 0;
    public static $CRAFTCATEGORY_TRANSPORTS = 1;
    public static $CRAFTCATEGORY_FREIGHTERSCONTAINERS = 2;
    public static $CRAFTCATEGORY_STARSHIPS = 3;
    public static $CRAFTCATEGORY_UTILITYCRAFT = 4;
    public static $CRAFTCATEGORY_PLATFORMSFACILITIES = 5;
    public static $CRAFTCATEGORY_MINES = 6;

    public static $OBJECTCATEGORY = [
        0 => "Craft",
        1 => "Weapons",
        2 => "Space Objects",
    ];

    public static $OBJECTCATEGORY_CRAFT = 0;
    public static $OBJECTCATEGORY_WEAPONS = 1;
    public static $OBJECTCATEGORY_SPACEOBJECTS = 2;

    public static $AMOUNT = [
        0 => "100%",
        1 => "75%",
        2 => "50%",
        3 => "25%",
        4 => "At least one",
        5 => "All but one",
        6 => "Special craft",
        7 => "All non-special craft",
        8 => "All non-player craft",
        9 => "Player's craft",
        10 => "100% of first wave",
        11 => "75% of first wave",
        12 => "50% of first wave",
        13 => "25% of first wave",
        14 => "At least one of first wave",
        15 => "All but one of first wave",
        16 => "66%",
        17 => "33%",
        18 => "Each craft",
    ];

    public static $AMOUNT_N100PERCENT = 0;
    public static $AMOUNT_N75PERCENT = 1;
    public static $AMOUNT_N50PERCENT = 2;
    public static $AMOUNT_N25PERCENT = 3;
    public static $AMOUNT_ATLEASTONE = 4;
    public static $AMOUNT_ALLBUTONE = 5;
    public static $AMOUNT_SPECIALCRAFT = 6;
    public static $AMOUNT_ALLNONSPECIALCRAFT = 7;
    public static $AMOUNT_ALLNONPLAYERCRAFT = 8;
    public static $AMOUNT_PLAYERSCRAFT = 9;
    public static $AMOUNT_N100PERCENTOFFIRSTWAVE = 10;
    public static $AMOUNT_N75PERCENTOFFIRSTWAVE = 11;
    public static $AMOUNT_N50PERCENTOFFIRSTWAVE = 12;
    public static $AMOUNT_N25PERCENTOFFIRSTWAVE = 13;
    public static $AMOUNT_ATLEASTONEOFFIRSTWAVE = 14;
    public static $AMOUNT_ALLBUTONEOFFIRSTWAVE = 15;
    public static $AMOUNT_N66PERCENT = 16;
    public static $AMOUNT_N33PERCENT = 17;
    public static $AMOUNT_EACHCRAFT = 18;

    public static $ABORTTRIGGER = [
        0 => "None",
        1 => "0% Shields",
        2 => "Unknown",
        3 => "Out of warheads",
        4 => "50% Hull",
        5 => "Attacked",
        6 => "50% Shields",
        7 => "25% Shields",
        8 => "75% Hull",
        9 => "25% Hull",
    ];

    public static $ABORTTRIGGER_NONE = 0;
    public static $ABORTTRIGGER_N0PERCENTSHIELDS = 1;
    public static $ABORTTRIGGER_UNKNOWN = 2;
    public static $ABORTTRIGGER_OUTOFWARHEADS = 3;
    public static $ABORTTRIGGER_N50PERCENTHULL = 4;
    public static $ABORTTRIGGER_ATTACKED = 5;
    public static $ABORTTRIGGER_N50PERCENTSHIELDS = 6;
    public static $ABORTTRIGGER_N25PERCENTSHIELDS = 7;
    public static $ABORTTRIGGER_N75PERCENTHULL = 8;
    public static $ABORTTRIGGER_N25PERCENTHULL = 9;

    public static $ORDER = [
        0 => "Hold Station",
        1 => "Go Home",
        2 => "Circle",
        3 => "Circle and Evade",
        4 => "Rendezvous",
        5 => "Disabled",
        6 => "Await Boarding",
        7 => "Attack",
        8 => "Attack Escorts",
        9 => "Protect",
        10 => "Escort",
        11 => "Disable",
        12 => "Board and Give Cargo",
        13 => "Board and Take Cargo",
        14 => "Board and Exchange Cargo",
        15 => "Board and Capture Cargo",
        16 => "Board and Destroy Cargo",
        17 => "Pick up",
        18 => "Drop off",
        19 => "Wait",
        20 => "SS Wait",
        21 => "SS Patrol Loop",
        22 => "SS Await Return",
        23 => "SS Launch",
        24 => "SS Protect",
        25 => "SS Wait and Protect",
        26 => "SS Patrol and Attack",
        27 => "SS Patrol and Disable",
        28 => "SS Hold Steady",
        29 => "SS Go Home",
        30 => "SS Wait",
        31 => "SS Board",
        32 => "Board to Repair",
        33 => "Hold Station",
        34 => "Hold Steady",
        35 => "SS Hold Station",
        36 => "Self-destruct",
        37 => "Kamikaze",
        38 => "SS Disabled",
        39 => "SS Hold Steady",
    ];

    public static $ORDER_HOLDSTATION = 0;
    public static $ORDER_GOHOME = 1;
    public static $ORDER_CIRCLE = 2;
    public static $ORDER_CIRCLEANDEVADE = 3;
    public static $ORDER_RENDEZVOUS = 4;
    public static $ORDER_DISABLED = 5;
    public static $ORDER_AWAITBOARDING = 6;
    public static $ORDER_ATTACK = 7;
    public static $ORDER_ATTACKESCORTS = 8;
    public static $ORDER_PROTECT = 9;
    public static $ORDER_ESCORT = 10;
    public static $ORDER_DISABLE = 11;
    public static $ORDER_BOARDANDGIVECARGO = 12;
    public static $ORDER_BOARDANDTAKECARGO = 13;
    public static $ORDER_BOARDANDEXCHANGECARGO = 14;
    public static $ORDER_BOARDANDCAPTURECARGO = 15;
    public static $ORDER_BOARDANDDESTROYCARGO = 16;
    public static $ORDER_PICKUP = 17;
    public static $ORDER_DROPOFF = 18;
    public static $ORDER_WAIT = 19;
    public static $ORDER_SSWAIT = 20;
    public static $ORDER_SSPATROLLOOP = 21;
    public static $ORDER_SSAWAITRETURN = 22;
    public static $ORDER_SSLAUNCH = 23;
    public static $ORDER_SSPROTECT = 24;
    public static $ORDER_SSWAITANDPROTECT = 25;
    public static $ORDER_SSPATROLANDATTACK = 26;
    public static $ORDER_SSPATROLANDDISABLE = 27;
    public static $ORDER_SSHOLDSTEADY = 28;
    public static $ORDER_SSGOHOME = 29;
    public static $ORDER_SSWAIT2 = 30;
    public static $ORDER_SSBOARD = 31;
    public static $ORDER_BOARDTOREPAIR = 32;
    public static $ORDER_HOLDSTATION2 = 33;
    public static $ORDER_HOLDSTEADY = 34;
    public static $ORDER_SSHOLDSTATION = 35;
    public static $ORDER_SELFDESTRUCT = 36;
    public static $ORDER_KAMIKAZE = 37;
    public static $ORDER_SSDISABLED = 38;
    public static $ORDER_SSHOLDSTEADY2 = 39;

    public static $CRAFTWHEN = [
        1 => "Inspected",
        2 => "Boarded",
        4 => "Disabled",
        5 => "Attacked",
        6 => "0% Shields?",
        7 => "Special craft",
        8 => "Non-special craft",
        9 => "Player's craft",
        10 => "Non-player's craft",
        12 => "not disabled",
    ];

    public static $CRAFTWHEN_INSPECTED = 1;
    public static $CRAFTWHEN_BOARDED = 2;
    public static $CRAFTWHEN_DISABLED = 4;
    public static $CRAFTWHEN_ATTACKED = 5;
    public static $CRAFTWHEN_N0PERCENTSHIELDS = 6;
    public static $CRAFTWHEN_SPECIALCRAFT = 7;
    public static $CRAFTWHEN_NONSPECIALCRAFT = 8;
    public static $CRAFTWHEN_PLAYERSCRAFT = 9;
    public static $CRAFTWHEN_NONPLAYERSCRAFT = 10;
    public static $CRAFTWHEN_NOTDISABLED = 12;

    public static $EVENTTYPE = [
        3 => "Stop",
        4 => "Title Text",
        5 => "Caption Text",
        6 => "Move Map",
        7 => "Zoom Map",
        8 => "Clear FG Tags",
        9 => "FG Tag 1",
        10 => "FG Tag 2",
        11 => "FG Tag 3",
        12 => "FG Tag 4",
        13 => "FG Tag 5",
        14 => "FG Tag 6",
        15 => "FG Tag 7",
        16 => "FG Tag 8",
        17 => "Clear Text Tags",
        18 => "Text Tag 1",
        19 => "Text Tag 2",
        20 => "Text Tag 3",
        21 => "Text Tag 4",
        22 => "Text Tag 5",
        23 => "Text Tag 6",
        24 => "Text Tag 7",
        25 => "Text Tag 8",
        34 => "End Briefing",
    ];

    public static $EVENTTYPE_STOP = 3;
    public static $EVENTTYPE_TITLETEXT = 4;
    public static $EVENTTYPE_CAPTIONTEXT = 5;
    public static $EVENTTYPE_MOVEMAP = 6;
    public static $EVENTTYPE_ZOOMMAP = 7;
    public static $EVENTTYPE_CLEARFGTAGS = 8;
    public static $EVENTTYPE_FGTAG1 = 9;
    public static $EVENTTYPE_FGTAG2 = 10;
    public static $EVENTTYPE_FGTAG3 = 11;
    public static $EVENTTYPE_FGTAG4 = 12;
    public static $EVENTTYPE_FGTAG5 = 13;
    public static $EVENTTYPE_FGTAG6 = 14;
    public static $EVENTTYPE_FGTAG7 = 15;
    public static $EVENTTYPE_FGTAG8 = 16;
    public static $EVENTTYPE_CLEARTEXTTAGS = 17;
    public static $EVENTTYPE_TEXTTAG1 = 18;
    public static $EVENTTYPE_TEXTTAG2 = 19;
    public static $EVENTTYPE_TEXTTAG3 = 20;
    public static $EVENTTYPE_TEXTTAG4 = 21;
    public static $EVENTTYPE_TEXTTAG5 = 22;
    public static $EVENTTYPE_TEXTTAG6 = 23;
    public static $EVENTTYPE_TEXTTAG7 = 24;
    public static $EVENTTYPE_TEXTTAG8 = 25;
    public static $EVENTTYPE_ENDBRIEFING = 34;

    public static $PLATFORMID = [
        18 => "XvT",
        20 => "BoP",
    ];

    public static $PLATFORMID_XVT = 18;
    public static $PLATFORMID_BOP = 20;

    public static $MISSIONTYPE = [
        0 => "Training",
        1 => "Unknown",
        2 => "Melee",
        3 => "Multiplayer Training",
        4 => "Multiplayer Combat",
    ];

    public static $MISSIONTYPE_TRAINING = 0;
    public static $MISSIONTYPE_UNKNOWN = 1;
    public static $MISSIONTYPE_MELEE = 2;
    public static $MISSIONTYPE_MULTIPLAYERTRAINING = 3;
    public static $MISSIONTYPE_MULTIPLAYERCOMBAT = 4;

    public static $TEAM = [
        49 => "Imperial",
        50 => "Rebel",
        51 => "Team 3",
        52 => "Team 4",
        97 => "All",
        104 => "Unknown",
    ];

    public static $TEAM_IMPERIAL = 49;
    public static $TEAM_REBEL = 50;
    public static $TEAM_TEAM3 = 51;
    public static $TEAM_TEAM4 = 52;
    public static $TEAM_ALL = 97;
    public static $TEAM_UNKNOWN = 104;

    public static $GOALARGUMENT = [
        0 => "must",
        1 => "must NOT",
        2 => "BONUS must",
        3 => "BONUS must NOT",
    ];

    public static $GOALARGUMENT_MUST = 0;
    public static $GOALARGUMENT_MUSTNOT = 1;
    public static $GOALARGUMENT_BONUSMUST = 2;
    public static $GOALARGUMENT_BONUSMUSTNOT = 3;

    public static $SHIPCATEGORY = [
        0 => "None",
        1 => "All Flyable",
        2 => "All Rebel Flyable",
        3 => "All Imperial Flyable",
        4 => "User Defined",
    ];

    public static $SHIPCATEGORY_NONE = 0;
    public static $SHIPCATEGORY_ALLFLYABLE = 1;
    public static $SHIPCATEGORY_ALLREBELFLYABLE = 2;
    public static $SHIPCATEGORY_ALLIMPERIALFLYABLE = 3;
    public static $SHIPCATEGORY_USERDEFINED = 4;
}

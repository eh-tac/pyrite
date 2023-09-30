<?php
namespace Pyrite\XW;

class Constants
{
    public static $PILOTSTATUS = [
        0 => "Normal",
        1 => "Captured",
        2 => "Killed",
    ];

    public static $PILOTSTATUS_NORMAL = 0;
    public static $PILOTSTATUS_CAPTURED = 1;
    public static $PILOTSTATUS_KILLED = 2;

    public static $PILOTRANK = [
        0 => "Cadet",
        1 => "Officer",
        2 => "Lieutenant",
        3 => "Captain",
        4 => "Commander",
        5 => "General",
    ];

    public static $PILOTRANK_CADET = 0;
    public static $PILOTRANK_OFFICER = 1;
    public static $PILOTRANK_LIEUTENANT = 2;
    public static $PILOTRANK_CAPTAIN = 3;
    public static $PILOTRANK_COMMANDER = 4;
    public static $PILOTRANK_GENERAL = 5;

    public static $KALIDORCRESCENT = [
        0 => "None",
        1 => "Kalidor Crescent",
        2 => "Bronze Cluster",
        3 => "Silver Talons",
        4 => "Silver Scimitar",
        5 => "Gold Wings",
        6 => "Diamond Eyes",
    ];

    public static $KALIDORCRESCENT_NONE = 0;
    public static $KALIDORCRESCENT_KALIDORCRESCENT = 1;
    public static $KALIDORCRESCENT_BRONZECLUSTER = 2;
    public static $KALIDORCRESCENT_SILVERTALONS = 3;
    public static $KALIDORCRESCENT_SILVERSCIMITAR = 4;
    public static $KALIDORCRESCENT_GOLDWINGS = 5;
    public static $KALIDORCRESCENT_DIAMONDEYES = 6;

    public static $TOURSTATUS = [
        0 => "Inactive",
        1 => "Active",
        2 => "Incomplete",
        3 => "Complete",
    ];

    public static $TOURSTATUS_INACTIVE = 0;
    public static $TOURSTATUS_ACTIVE = 1;
    public static $TOURSTATUS_INCOMPLETE = 2;
    public static $TOURSTATUS_COMPLETE = 3;

    public static $TOURMEDALS = [
        1 => "Corellian Cross",
        2 => "Mantooine Medallion",
        3 => "Star Of Alderaan",
        4 => "Shield Of Yavin",
        5 => "Talons Of Hoth",
    ];

    public static $TOURMEDALS_CORELLIANCROSS = 1;
    public static $TOURMEDALS_MANTOOINEMEDALLION = 2;
    public static $TOURMEDALS_STAROFALDERAAN = 3;
    public static $TOURMEDALS_SHIELDOFYAVIN = 4;
    public static $TOURMEDALS_TALONSOFHOTH = 5;

    public static $SHIPTYPE = [
        0 => "X-Wing",
        1 => "Y-Wing",
        2 => "A-Wing",
        3 => "TIE Fighter",
        4 => "TIE Interceptor",
        5 => "TIE Bomber",
        6 => "Assault Gunboat",
        7 => "Transport",
        8 => "Shuttle",
        9 => "Tug",
        10 => "Container",
        11 => "Freighter",
        12 => "Calamari",
        13 => "NebulonB",
        14 => "Corvette",
        15 => "Star Destroyer",
        16 => "TIE Advanced",
        17 => "Mine1",
        18 => "Mine2",
        19 => "Mine3",
        20 => "Mine4",
        21 => "CommSat1",
        22 => "CommSat2",
        23 => "Probe",
    ];

    public static $SHIPTYPE_XWING = 0;
    public static $SHIPTYPE_YWING = 1;
    public static $SHIPTYPE_AWING = 2;
    public static $SHIPTYPE_TIEFIGHTER = 3;
    public static $SHIPTYPE_TIEINTERCEPTOR = 4;
    public static $SHIPTYPE_TIEBOMBER = 5;
    public static $SHIPTYPE_ASSAULTGUNBOAT = 6;
    public static $SHIPTYPE_TRANSPORT = 7;
    public static $SHIPTYPE_SHUTTLE = 8;
    public static $SHIPTYPE_TUG = 9;
    public static $SHIPTYPE_CONTAINER = 10;
    public static $SHIPTYPE_FREIGHTER = 11;
    public static $SHIPTYPE_CALAMARI = 12;
    public static $SHIPTYPE_NEBULONB = 13;
    public static $SHIPTYPE_CORVETTE = 14;
    public static $SHIPTYPE_STARDESTROYER = 15;
    public static $SHIPTYPE_TIEADVANCED = 16;
    public static $SHIPTYPE_MINE1 = 17;
    public static $SHIPTYPE_MINE2 = 18;
    public static $SHIPTYPE_MINE3 = 19;
    public static $SHIPTYPE_MINE4 = 20;
    public static $SHIPTYPE_COMMSAT1 = 21;
    public static $SHIPTYPE_COMMSAT2 = 22;
    public static $SHIPTYPE_PROBE = 23;

    public static $ENDEVENT = [
        0 => "Rescued",
        1 => "Captured",
        5 => "Hit Exhaust Port",
    ];

    public static $ENDEVENT_RESCUED = 0;
    public static $ENDEVENT_CAPTURED = 1;
    public static $ENDEVENT_HITEXHAUSTPORT = 5;

    public static $MISSIONLOCATION = [
        0 => "Deep Space",
        1 => "Death Star",
    ];

    public static $MISSIONLOCATION_DEEPSPACE = 0;
    public static $MISSIONLOCATION_DEATHSTAR = 1;

    public static $CRAFTTYPE = [
        0 => "None",
        1 => "X-Wing",
        2 => "Y-Wing",
        3 => "A-Wing",
        4 => "TIE Fighter",
        5 => "TIE Interceptor",
        6 => "TIE Bomber",
        7 => "Assault Gunboat",
        8 => "Transport",
        9 => "Shuttle",
        10 => "Tug",
        11 => "Container",
        12 => "Freighter",
        13 => "Calamari Cruiser",
        14 => "Nebulon B Frigate",
        15 => "Corellian Corvette",
        16 => "Imperial Star Destroyer",
        17 => "TIE Advanced",
        18 => "B-Wing",
    ];

    public static $CRAFTTYPE_NONE = 0;
    public static $CRAFTTYPE_XWING = 1;
    public static $CRAFTTYPE_YWING = 2;
    public static $CRAFTTYPE_AWING = 3;
    public static $CRAFTTYPE_TIEFIGHTER = 4;
    public static $CRAFTTYPE_TIEINTERCEPTOR = 5;
    public static $CRAFTTYPE_TIEBOMBER = 6;
    public static $CRAFTTYPE_ASSAULTGUNBOAT = 7;
    public static $CRAFTTYPE_TRANSPORT = 8;
    public static $CRAFTTYPE_SHUTTLE = 9;
    public static $CRAFTTYPE_TUG = 10;
    public static $CRAFTTYPE_CONTAINER = 11;
    public static $CRAFTTYPE_FREIGHTER = 12;
    public static $CRAFTTYPE_CALAMARICRUISER = 13;
    public static $CRAFTTYPE_NEBULONBFRIGATE = 14;
    public static $CRAFTTYPE_CORELLIANCORVETTE = 15;
    public static $CRAFTTYPE_IMPERIALSTARDESTROYER = 16;
    public static $CRAFTTYPE_TIEADVANCED = 17;
    public static $CRAFTTYPE_BWING = 18;

    public static $IFF = [
        0 => "Default",
        1 => "Rebel",
        2 => "Imperial",
        3 => "Neutral",
        4 => "Neutral (also Blue)",
    ];

    public static $IFF_DEFAULT = 0;
    public static $IFF_REBEL = 1;
    public static $IFF_IMPERIAL = 2;
    public static $IFF_NEUTRAL = 3;
    public static $IFF_NEUTRALALSOBLUE = 4;

    public static $FLIGHTGROUPSTATUS = [
        0 => "None",
        1 => "No Warheads",
        2 => "1/2 Warheads",
        3 => "No Shields",
        4 => "1/2 Shields",
        10 => "Y-wing to B-wing Normal Status",
        11 => "BW No warheads",
        12 => "BW 1/2 Warheads",
        13 => "BW No Shields",
        14 => "BW 1/2 Shields",
    ];

    public static $FLIGHTGROUPSTATUS_NONE = 0;
    public static $FLIGHTGROUPSTATUS_NOWARHEADS = 1;
    public static $FLIGHTGROUPSTATUS_N12WARHEADS = 2;
    public static $FLIGHTGROUPSTATUS_NOSHIELDS = 3;
    public static $FLIGHTGROUPSTATUS_N12SHIELDS = 4;
    public static $FLIGHTGROUPSTATUS_YWINGTOBWINGNORMALSTATUS = 10;
    public static $FLIGHTGROUPSTATUS_BWNOWARHEADS = 11;
    public static $FLIGHTGROUPSTATUS_BW12WARHEADS = 12;
    public static $FLIGHTGROUPSTATUS_BWNOSHIELDS = 13;
    public static $FLIGHTGROUPSTATUS_BW12SHIELDS = 14;

    public static $GROUPAI = [
        0 => "Novice (None)",
        1 => "Officer",
        2 => "Veteran",
        3 => "Ace",
        4 => "Top Ace",
    ];

    public static $GROUPAI_NOVICENONE = 0;
    public static $GROUPAI_OFFICER = 1;
    public static $GROUPAI_VETERAN = 2;
    public static $GROUPAI_ACE = 3;
    public static $GROUPAI_TOPACE = 4;

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

    public static $OBJECTFORMATION = [
        0 => "Floor (X-Y plane)",
        1 => "Side (Y-Z plane)",
        2 => "Front (X-Z plane)",
        3 => "Scattered (may be buggy, undefined locations)",
    ];

    public static $OBJECTFORMATION_FLOORXYPLANE = 0;
    public static $OBJECTFORMATION_SIDEYZPLANE = 1;
    public static $OBJECTFORMATION_FRONTXZPLANE = 2;
    public static $OBJECTFORMATION_SCATTEREDMAYBEBUGGYUNDEFINEDLOCATIONS = 3;

    public static $ARRIVALEVENT = [
        0 => "Mission Start",
        1 => "On Arrival",
        2 => "On Destroyed",
        3 => "On Attacked",
        4 => "On Boarded",
        5 => "On Identified",
        6 => "On Disabled",
    ];

    public static $ARRIVALEVENT_MISSIONSTART = 0;
    public static $ARRIVALEVENT_ONARRIVAL = 1;
    public static $ARRIVALEVENT_ONDESTROYED = 2;
    public static $ARRIVALEVENT_ONATTACKED = 3;
    public static $ARRIVALEVENT_ONBOARDED = 4;
    public static $ARRIVALEVENT_ONIDENTIFIED = 5;
    public static $ARRIVALEVENT_ONDISABLED = 6;

    public static $FORMATION = [
        0 => "Vic",
        1 => "Finger Four",
        2 => "Line Astern",
        3 => "Line Abrest",
        4 => "Echelon Right",
        5 => "Echelon Left",
        6 => "Double Astern",
        7 => "Diamond",
        8 => "Stacked",
        9 => "Spread",
        16 => "Hi-Lo",
        17 => "Spiral",
    ];

    public static $FORMATION_VIC = 0;
    public static $FORMATION_FINGERFOUR = 1;
    public static $FORMATION_LINEASTERN = 2;
    public static $FORMATION_LINEABREST = 3;
    public static $FORMATION_ECHELONRIGHT = 4;
    public static $FORMATION_ECHELONLEFT = 5;
    public static $FORMATION_DOUBLEASTERN = 6;
    public static $FORMATION_DIAMOND = 7;
    public static $FORMATION_STACKED = 8;
    public static $FORMATION_SPREAD = 9;
    public static $FORMATION_HILO = 16;
    public static $FORMATION_SPIRAL = 17;

    public static $OBJECTIVE = [
        0 => "None",
        1 => "100% be Destroyed",
        2 => "100% must Complete Mission",
        3 => "100% be Captured",
        4 => "100% be Boarded",
        5 => "special craft Destroyed",
        6 => "special craft Complete Mission",
        7 => "special craft Captured",
        8 => "special craft Boarded",
        9 => "50% Destroyed",
        10 => "50% Complete Mission",
        11 => "50% Captured",
        12 => "50% Boarded",
        13 => "100% identified",
        14 => "special craft identified",
        15 => "50% identified",
        16 => "Arrive",
    ];

    public static $OBJECTIVE_NONE = 0;
    public static $OBJECTIVE_N100PERCENTBEDESTROYED = 1;
    public static $OBJECTIVE_N100PERCENTMUSTCOMPLETEMISSION = 2;
    public static $OBJECTIVE_N100PERCENTBECAPTURED = 3;
    public static $OBJECTIVE_N100PERCENTBEBOARDED = 4;
    public static $OBJECTIVE_SPECIALCRAFTDESTROYED = 5;
    public static $OBJECTIVE_SPECIALCRAFTCOMPLETEMISSION = 6;
    public static $OBJECTIVE_SPECIALCRAFTCAPTURED = 7;
    public static $OBJECTIVE_SPECIALCRAFTBOARDED = 8;
    public static $OBJECTIVE_N50PERCENTDESTROYED = 9;
    public static $OBJECTIVE_N50PERCENTCOMPLETEMISSION = 10;
    public static $OBJECTIVE_N50PERCENTCAPTURED = 11;
    public static $OBJECTIVE_N50PERCENTBOARDED = 12;
    public static $OBJECTIVE_N100PERCENTIDENTIFIED = 13;
    public static $OBJECTIVE_SPECIALCRAFTIDENTIFIED = 14;
    public static $OBJECTIVE_N50PERCENTIDENTIFIED = 15;
    public static $OBJECTIVE_ARRIVE = 16;

    public static $ORDER = [
        0 => "Hold Steady",
        1 => "Fly Home",
        2 => "Circle and Ignore",
        3 => "Fly Once and Ignore",
        4 => "Circle and Evade",
        5 => "Fly Once and Evade",
        6 => "Close Escort",
        7 => "Loose Escort",
        8 => "Attack Escorts",
        9 => "Attack Targets",
        10 => "Attack Enemies",
        11 => "Rendezous",
        12 => "Disabled",
        13 => "Board to Deliver",
        14 => "Board to Take",
        15 => "Board to Exchange",
        16 => "Board to Capture",
        17 => "Board to Destroy",
        18 => "Disable Targets",
        19 => "Disable All",
        20 => "Attack Transports",
        21 => "Attack Freighters",
        22 => "Attack Starships",
        23 => "Attack Satellites and Mines",
        24 => "Disable Freighters",
        25 => "Disable Starships",
        26 => "Starship Static Fire",
        27 => "Starship Fly Dance",
        28 => "Starship Circle",
        29 => "Starship Await Return",
        30 => "Starship Await Launch",
        31 => "Starship Await Boarding",
    ];

    public static $ORDER_HOLDSTEADY = 0;
    public static $ORDER_FLYHOME = 1;
    public static $ORDER_CIRCLEANDIGNORE = 2;
    public static $ORDER_FLYONCEANDIGNORE = 3;
    public static $ORDER_CIRCLEANDEVADE = 4;
    public static $ORDER_FLYONCEANDEVADE = 5;
    public static $ORDER_CLOSEESCORT = 6;
    public static $ORDER_LOOSEESCORT = 7;
    public static $ORDER_ATTACKESCORTS = 8;
    public static $ORDER_ATTACKTARGETS = 9;
    public static $ORDER_ATTACKENEMIES = 10;
    public static $ORDER_RENDEZOUS = 11;
    public static $ORDER_DISABLED = 12;
    public static $ORDER_BOARDTODELIVER = 13;
    public static $ORDER_BOARDTOTAKE = 14;
    public static $ORDER_BOARDTOEXCHANGE = 15;
    public static $ORDER_BOARDTOCAPTURE = 16;
    public static $ORDER_BOARDTODESTROY = 17;
    public static $ORDER_DISABLETARGETS = 18;
    public static $ORDER_DISABLEALL = 19;
    public static $ORDER_ATTACKTRANSPORTS = 20;
    public static $ORDER_ATTACKFREIGHTERS = 21;
    public static $ORDER_ATTACKSTARSHIPS = 22;
    public static $ORDER_ATTACKSATELLITESANDMINES = 23;
    public static $ORDER_DISABLEFREIGHTERS = 24;
    public static $ORDER_DISABLESTARSHIPS = 25;
    public static $ORDER_STARSHIPSTATICFIRE = 26;
    public static $ORDER_STARSHIPFLYDANCE = 27;
    public static $ORDER_STARSHIPCIRCLE = 28;
    public static $ORDER_STARSHIPAWAITRETURN = 29;
    public static $ORDER_STARSHIPAWAITLAUNCH = 30;
    public static $ORDER_STARSHIPAWAITBOARDING = 31;

    public static $CRAFTCOLOUR = [
        0 => "Red",
        1 => "Gold",
        2 => "Blue",
    ];

    public static $CRAFTCOLOUR_RED = 0;
    public static $CRAFTCOLOUR_GOLD = 1;
    public static $CRAFTCOLOUR_BLUE = 2;

    public static $OBJECTOBJECTIVE = [
        3 => "None",
        4 => "Destroy",
        5 => "Survive",
    ];

    public static $OBJECTOBJECTIVE_NONE = 3;
    public static $OBJECTOBJECTIVE_DESTROY = 4;
    public static $OBJECTOBJECTIVE_SURVIVE = 5;

}
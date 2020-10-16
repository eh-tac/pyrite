<?php
namespace Pyrite\XW;

class Constants
{
    public static $PILOTSTATUS = [
        0 => "Normal",
        1 => "Captured",
        2 => "Killed",
    ];

    public static $PILOTRANK = [
        0 => "Cadet",
        1 => "Officer",
        2 => "Lieutenant",
        3 => "Captain",
        4 => "Commander",
        5 => "General",
    ];

    public static $KALIDORCRESCENT = [
        0 => "None",
        1 => "Kalidor Crescent",
        2 => "Bronze Cluster",
        3 => "Silver Talons",
        4 => "Silver Scimitar",
        5 => "Gold Wings",
        6 => "Diamond Eyes",
    ];

    public static $TOURSTATUS = [
        0 => "Inactive",
        1 => "Active",
        2 => "Incomplete",
        3 => "Complete",
    ];

    public static $TOURMEDALS = [
        1 => "Corellian Cross",
        2 => "Mantooine Medallion",
        3 => "Star Of Alderaan",
        4 => "Shield Of Yavin",
        5 => "Talons Of Hoth",
    ];

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

    public static $ENDSTATE = [
        0 => "Rescued",
        1 => "Captured",
        5 => "Hit Exhaust Port",
    ];

    public static $MISSIONLOCATION = [
        0 => "Deep Space",
        1 => "Death Star",
    ];

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

    public static $IFF = [
        0 => "Default",
        1 => "Rebel",
        2 => "Imperial",
        3 => "Neutral",
    ];

    public static $FLIGHTGROUPSTATUS = [
        0 => "Normal",
        1 => "No Missiles",
        2 => "Half Missiles",
        3 => "No Shields",
    ];

    public static $ARRIVALEVENT = [
        0 => "Mission Start",
        1 => "On Arrival",
        2 => "On Destroyed",
        3 => "On Attacked",
        4 => "On Boarded",
        5 => "On Identified",
        6 => "On Disabled",
    ];

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

    public static $CRAFTAI = [
        0 => "Rookie",
        1 => "Officer",
        2 => "Veteran",
        3 => "Ace",
        4 => "Top Ace",
    ];

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

    public static $CRAFTCOLOUR = [
        0 => "Red",
        1 => "Gold",
        2 => "Blue",
    ];

    public static $CRAFTOBJECTIVE = [
        0 => "None",
        1 => "All Destroyed",
        2 => "All Survive",
        3 => "All Captured",
        4 => "All Docked",
        5 => "Special Craft Destroyed",
        6 => "Special Craft Survive",
        7 => "Special Craft Captured",
        8 => "Special Craft Docked",
        9 => "Half Destroyed",
        10 => "Half Survive",
        11 => "Half Captured",
        12 => "Half Docked",
        13 => "All Identified",
        14 => "Special Craft Identified",
        15 => "Half Identified",
        16 => "Arrived",
    ];

}
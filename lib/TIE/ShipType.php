<?php

namespace Pyrite\TIE;

class ShipType
{
    public $ID;
    public $Name;
    public $Abbr;

    public function __construct($ID)
    {
        $this->ID = $ID;
        $this->Name = $this->getName();
        $this->Abbr = $this->getAbbr();
    }

    public function isStarship()
    {
        switch ($this->Name) {
                //TODO decide on the canonical source of names
            case 'Corellian Corvette':
            case 'Modified Corvette':
            case 'Nebulon B Frigate':
            case 'Modified Frigate':
            case 'C-3 Passenger Liner':
            case 'Carrack Cruiser':
            case 'Strike Cruiser':
            case 'Escort Carrier':
            case 'Dreadnaught':
            case 'Calamari Cruiser':
            case 'Lt Calamari Cruiser':
            case 'Interdictor Cruiser':
            case 'Victory-class Star Destroyer':
            case 'Victory Star Destroyer':
            case 'Star Destroyer':
            case 'Super Star Destroyer':
                return true;
            default:
                return false;
        }
    }

    public function isFighter()
    {
        return $this->ID < 25;
    }

    private function getName()
    {
        $names = Constants::$CRAFTTYPE;
        return isset($names[$this->ID]) ? $names[$this->ID] : 'Unknown type ' . $this->ID;
    }

    private function getAbbr()
    {
        $names = Constants::$CRAFTABBR;
        return isset($names[$this->ID]) ? $names[$this->ID] : 'Unknown type ' . $this->ID;
    }

    public function pointValue()
    {
        $points = array(
            0, 600, 400, 800, 800, 400, 600, 600, 1000, 1600, 400, //patch slot 10
            400, //patch slot 11
            1000, 400, 320, 480, 800, 800, 1600, 2400, 2400,
            600, 960, 1200, 200, 240, 800, 800, 800, 800,
            600, 1200, 1200, 1600, 1200, 1600, 2400, 2000, 2000, 2200, //'Millenium Falcon/ slot 39',
            1600,
            2000, 4400, 4000, 4000, 4400, 4000, 4000, 5000, 6000, 5000,
            5600, 5000, 8000, 4000, //SSD,
            800, 800, 800,
            800, 800, 5200, 5200, 5200, 5200, 5200, 5200, 5200, 5200, 5200,
            5200, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, //gun emplacement
            50, 50, 50, 50, 50, 50, 0, //asteroid,
            0 //'Planet'
        );
        return isset($points[$this->ID]) ? (int)$points[$this->ID] : 0;
    }

    public function __toString()
    {
        return $this->Name;
    }

    public function missileCount()
    {
        $missiles = array(
            'Unassigned', 'X-Wing', 'Y-Wing', 'A-Wing', 'B-Wing', 4, 6, 8, 8, 8, 'Slot 10',
            'Slot 11', 80, 'T-Wing', 'Z-95 Headhunter', 'R-41 Starchaser', 16
        );
        return isset($missiles[$this->ID]) ? (int)$missiles[$this->ID] : 0;
    }
}

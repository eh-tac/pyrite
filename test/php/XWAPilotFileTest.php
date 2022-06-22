<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pyrite\XWA\PilotFile;

require_once(__DIR__ . '/../../vendor/autoload.php');

class XWAPilotFileTest extends TestCase
{
    public function testBattle8Position()
    {
        $b8Path = __DIR__ . '/../data/TESTER80.plt';
        $data = file_get_contents($b8Path);
        $pilotFile = PilotFile::fromHex($data);
        $this->assertEquals(53, $pilotFile->getCurrentMissionID());
    }

    public function testChangeOffset()
    {
        $b8Path = __DIR__ . '/../data/TESTER80.plt';
        $data = file_get_contents($b8Path);
        $pilotFile = PilotFile::fromHex($data);
        $pilotFile->setUpForMissionID(3);
        $this->assertEquals(3, $pilotFile->getCurrentMissionID());
    }

    public function testSerialiseMissionData()
    {
        $b8Path = __DIR__ . '/../data/TESTER80.plt';
        $data = file_get_contents($b8Path);
        $pilotFile = PilotFile::fromHex($data);
        $mission = $pilotFile->MissionData[0];
        $oldHex = substr($mission->hex, 0, $mission->getLength());
        $newHex = $mission->toHexString();
        $this->assertEquals(strlen($oldHex), strlen($newHex));
        $this->assertEquals($oldHex, $newHex);
    }

    public function testSerialisePilotFile()
    {
        $b8Path = __DIR__ . '/../data/TESTER80.plt';
        $data = file_get_contents($b8Path);
        $pilotFile = PilotFile::fromHex($data);
        $oldHex = $data;
        $newHex = $pilotFile->toHexString($oldHex);
        $nexHex[0x2e] = $oldHex[0x2e];
        $this->assertEquals(strlen($oldHex), strlen($newHex));
        $this->assertEquals(substr($oldHex, 0, 0xD2), substr($newHex, 0, 0xD2));
    }

    public function testReadPilotFile()
    {
        $tftcPath = __DIR__ . '/../data/PickledYoda0.plt';
        $data = file_get_contents($tftcPath);
        $pilotFile = PilotFile::fromHex($data);

        $this->assertEquals("PickledYoda", $pilotFile->Name);
        $this->assertEquals(67559, $pilotFile->TotalScore);
        $this->assertEquals(275, $pilotFile->getTotalKills());
        $this->assertEquals(84, $pilotFile->getTotalPartials());
        $this->assertEquals(114350, $pilotFile->getTotalBonusScore());
        $this->assertEquals(2, $pilotFile->CraftLosses);
        $this->assertEquals(4457, $pilotFile->LasersHit);
        $this->assertEquals(9172, $pilotFile->LasersFired);
        $this->assertEquals(686, $pilotFile->WarheadsHit);
        $this->assertEquals(1028, $pilotFile->WarheadsFired);

        $kills = $pilotFile->getCraftKillArray(true);

        // check some kills by type
        $this->checkKills($kills, "A-Wing", 17, 3);
        $this->checkKills($kills, "B-Wing", 4, 5);
        $this->checkKills($kills, "Cloakshape Fighter", 1, 3);
        $this->checkKills($kills, "Skipray Blastboat", 3, 2);
        $this->checkKills($kills, "X-Wing", 24, 5);
        $this->checkKills($kills, "Y-Wing", 77, 41);
        $this->checkKills($kills, "Y-Wing/B", 3, 2);
        $this->checkKills($kills, "Z-95 Headhunter", 54, 9);
        $this->checkKills($kills, "Escort Shuttle", 2, 1);
        $this->checkKills($kills, "Lambda Shuttle", 2, 4);
        $this->checkKills($kills, "Stormtrooper Transport", 5, 5);
        $this->checkKills($kills, "CN/A Brick", 11, 0);
        $this->checkKills($kills, "CN/B Hexbox", 8, 0);
        $this->checkKills($kills, "CN/D Pronged", 8, 0);
        $this->checkKills($kills, "Bulk Freighter", 3, 0);
        $this->checkKills($kills, "Cargo Ferry", 2, 1);
        $this->checkKills($kills, "Corellian Gunship", 2, 0);
        $this->checkKills($kills, "Mobquet Transport", 1, 0);
        $this->checkKills($kills, "Xiytiar Transport", 1, 0);
        $this->checkKills($kills, "Acclamator Cruiser", 2, 0);
        $this->checkKills($kills, "Bulk Cruiser", 1, 0);
        $this->checkKills($kills, "Carrack Cruiser", 1, 0);
        $this->checkKills($kills, "Commerce Guild Destroyer", 2, 0);
        $this->checkKills($kills, "Corellian Corvette", 3, 2);
        $this->checkKills($kills, "Marauder Corvette", 0, 1);
        $this->checkKills($kills, "MC80 Liberty Star Cruiser", 1, 0);
        $this->checkKills($kills, "MC80A Chatnoir Star Cruiser", 1, 0);
        $this->checkKills($kills, "Modified Corvette", 2, 0);
        $this->checkKills($kills, "Nebulon-B Frigate", 1, 0);
        $this->checkKills($kills, "Industrial Complex", 1, 0);
        $this->checkKills($kills, "Pirate Asteroid Base", 1, 0);
        $this->checkKills($kills, "Large Gun Emplacement", 1, 0);
        $this->checkKills($kills, "Mine1", 24, 0);
        $this->checkKills($kills, "Mine3", 6, 0);
    }

    private function checkKills($map, $type, $kill, $partial)
    {
        $this->assertEquals(true, array_key_exists($type, $map));
        $this->assertEquals($kill, $map[$type][0]);
        $this->assertEquals($partial, $map[$type][1]);
    }
}

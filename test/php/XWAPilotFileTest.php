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
        $pilotFile = new PilotFile($data);
        $this->assertEquals(53, $pilotFile->getCurrentMissionID());
    }

    public function testChangeOffset()
    {
        $b8Path = __DIR__ . '/../data/TESTER80.plt';
        $data = file_get_contents($b8Path);
        $pilotFile = new PilotFile($data);
        $pilotFile->setUpForMissionID(3);
        $this->assertEquals(3, $pilotFile->getCurrentMissionID());
    }

    public function testSerialiseMissionData()
    {
        $b8Path = __DIR__ . '/../data/TESTER80.plt';
        $data = file_get_contents($b8Path);
        $pilotFile = new PilotFile($data);
        $mission = $pilotFile->MissionData[0];
        $oldHex = substr($mission->hex, 0, $mission->getLength());
        $newHex = $mission->toHexString();
        $this->assertEquals(strlen($oldHex), strlen($newHex));
        $this->assertEquals($oldHex, $newHex);
    }
}

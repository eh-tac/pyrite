<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pyrite\XWVM\PilotFile;

final class XWVMPilotFileTest extends TestCase
{
    public function testLockeTestAParsesBattleScores(): void
    {
        $pilot = PilotFile::load(__DIR__ . '/../../fixtures/xwvm/LockeTestA.vmpilot');

        $this->assertTrue($pilot->isValid());
        $this->assertEquals('LockeTest', $pilot->Name);

        $battles = $pilot->getBattles();
        $this->assertArrayHasKey('XWVMTC2', $battles);
        $this->assertCount(4, $battles['XWVMTC2']['missions']);
        $this->assertEquals([2065, 2205, 18636, 11845], array_column($battles['XWVMTC2']['missions'], 'score'));
        $this->assertEquals([1, 2, 3, 4], array_column($battles['XWVMTC2']['missions'], 'mission'));
        $this->assertEquals(['XWVMTC2'], $pilot->listCompleteBattles());
        $this->assertSame($battles['XWVMTC2'], $pilot->getBattle('XWVMTC2'));
        $this->assertNull($pilot->getBattle('TC2'));
        $this->assertEquals([2065, 2205, 18636, 11845], $pilot->getCompletedMissionScores());
    }

    public function testLockeTestBIncludesIncompleteNamedScores(): void
    {
        $pilot = PilotFile::load(__DIR__ . '/../../fixtures/xwvm/LockeTestB.vmpilot');

        $this->assertTrue($pilot->isValid());

        $battles = $pilot->getBattles();
        $this->assertEquals(['XWVMTC2', 'XWVMF2', 'XWVMF3'], array_keys($battles));
        $this->assertCount(6, $pilot->getMissionScores());
        $this->assertEquals([2065, 2205, 18636, 11845, 11350, 11622], $pilot->getCompletedMissionScores());

        $this->assertArrayHasKey('XWVMF2', $battles);
        $this->assertFalse($battles['XWVMF2']['completed']);
        $this->assertEquals('Incomplete', $battles['XWVMF2']['status']);
        $this->assertEquals('XWVMF2M1', $battles['XWVMF2']['missions'][0]['name']);
        $this->assertEquals(11350, $battles['XWVMF2']['missions'][0]['score']);
        $this->assertFalse($battles['XWVMF2']['missions'][0]['completed']);

        $this->assertEquals(['XWVMTC2', 'XWVMF3'], $pilot->listCompleteBattles());
        $this->assertSame($battles['XWVMF2'], $pilot->getBattle('XWVMF2'));
        $this->assertEquals([2065, 2205, 18636, 11845, 11622], $pilot->getCompletedMissionScores(true));
    }

    public function testMalformedXmlIsInvalid(): void
    {
        $pilot = PilotFile::fromXml('<PilotRecord><PilotGameRecord></PilotRecord>');

        $this->assertFalse($pilot->isValid());
        $this->assertNotEmpty($pilot->getErrors());
        $this->assertSame([], $pilot->getBattleSummary());
        $this->assertSame([], $pilot->getMissionScores());
    }
}

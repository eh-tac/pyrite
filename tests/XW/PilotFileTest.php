<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class XWPilotFileTest extends TestCase
{
    public function testVanguard717CompletedMissionScores(): void
    {
        $dir = dirname(__FILE__);
        $xw = \Pyrite\XW\PilotFile::fromHex(file_get_contents($dir . '/../data/VANGUARD717.PLT'));
        $scores = $xw->getCompletedMissionScores(true);
        $this->assertCount(78, $scores, 'VANGUARD717.PLT should have 5 battles of data');
        $this->assertCount(20, $xw->getTour4Scores(), 'reduces the 24 indexes to scores of 20');
        foreach ($xw->getTour4Scores() as $score) {
            $this->assertNotEquals(0, $score, 'All Tour 4 scores should be non-zero');
        }
        foreach ($xw->getTour5Scores() as $score) {
            $this->assertNotEquals(0, $score, 'All Tour 5 scores should be non-zero');
        }
        $this->assertCount(20, $xw->getTour5Scores(), 'reduces the 24 indexes to scores of 20');
    }

    public function testXwCmp2CompletedMissionScores(): void
    {
        $dir = dirname(__FILE__);
        $xw = \Pyrite\XW\PilotFile::fromHex(file_get_contents($dir . '/../data/XWCMP2.plt'));
        $xw->loadHex();
        $scores = $xw->getCompletedMissionScores();
        
        // Should have data for battle 2 only
        // In campaign mode, we expect only the tour missions
        $this->assertGreaterThan(0, count($scores), 'XWCMP2.plt should have battle 2 data');
    }
}

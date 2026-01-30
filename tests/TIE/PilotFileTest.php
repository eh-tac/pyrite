<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TIEPilotFileTest extends TestCase
{
    public function testSkillScore(): void
    {
        $dir = dirname(__FILE__);
        $tie = \Pyrite\TIE\PilotFile::load($dir . '/../data/TIETC19.tfr');
        $tie->loadHex();
        $this->assertEquals(65535, $tie->SkillScore);
    }

    public function testPhoenixCampaign(): void
    {
        $dir = dirname(__FILE__);
        $tie = \Pyrite\TIE\PilotFile::load($dir . '/../data/PHOENIX.TFR');
        $tie->loadHex();
        $scores = $tie->getCompletedMissionScores(true);
        $this->assertCount(160, $scores, 'PHOENIX.TFR should have 13 battles of data which is 76 missions but 160 slots are returned');
        $nonZero = array_filter($scores, fn($score) => $score > 0);
        $this->assertCount(76, $nonZero, 'PHOENIX.TFR should have 76 missions with non-zero scores');
    }

    public function testTieCmp12CompletedMissionScores(): void
    {
        $dir = dirname(__FILE__);
        $tie = \Pyrite\TIE\PilotFile::load($dir . '/../data/TIECMP12.tfr');
        $tie->loadHex();
        $scores = $tie->getCompletedMissionScores(true);
        $this->assertCount(160, $scores, 'TIECMP12.tfr should have 20 battles of data which is 160 missions');
        
        // First 11 battles should have 0 scores x 8 missions each
        for ($i = 0; $i < 88; $i++) {
            $this->assertEquals(0, $scores[$i], "Mission " . ($i + 1) . " should have a score of 0");
        }

        for ($i = 88; $i < 95; $i++) {
            $this->assertGreaterThan(0, $scores[$i], "Mission " . ($i + 1) . " should have a score because battle 12 was flown");
        }

        // Battles 13-20 should have 0 scores
        for ($i = 96; $i < 160; $i++) {
            $this->assertEquals(0, $scores[$i], "Mission " . ($i + 1) . " should have a score of 0");
        }
    }
}

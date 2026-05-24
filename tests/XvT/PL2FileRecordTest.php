<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PL2FileRecordTest extends TestCase
{
    private function getFixturePath(): string
    {
        return dirname(__DIR__, 2) . '/test/data/VanguardBOP0.pl2';
    }

    public function testCampaignTotalScoreMatchesCompletedMissionScores(): void
    {
        $hex = file_get_contents($this->getFixturePath());
        $pilot = \Pyrite\XvT\PL2FileRecord::fromHex($hex);
        $scores = $pilot->getCompletedMissionScores(true);

        $this->assertCount(15, $scores);
        $this->assertSame(1729938, array_sum($scores));
        $this->assertSame($pilot->getCampaignTotalScore(), array_sum($scores));
    }

    public function testOutputMatchesInput(): void
    {
        $hex = file_get_contents($this->getFixturePath());
        $pilot = \Pyrite\XvT\PL2FileRecord::fromHex($hex);

        $this->assertSame($hex, $pilot->toHexString());
    }
}
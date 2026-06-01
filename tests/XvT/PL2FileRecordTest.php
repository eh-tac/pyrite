<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PL2FileRecordTest extends TestCase
{
    private function getFixturePath(): string
    {
        return dirname(__DIR__, 2) . '/fixtures/VanguardBOP0.pl2';
    }

    private function getEditFixturePath(): string
    {
        return dirname(__DIR__, 2) . '/fixtures/edit/VanguardBOP0.pl2';
    }

    private function loadFixture(): array
    {
        $hex = file_get_contents($this->getFixturePath());

        return [$hex, \Pyrite\XvT\PL2FileRecord::fromHex($hex)];
    }

    public function testCampaignValidation(): void
    {
        [, $pilot] = $this->loadFixture();
        $scores = $pilot->getCompletedMissionScores(true);
        $scoreSum = array_sum($scores);
        $bestScores = array_map(static function ($campaign) {
            return $campaign->bestScore;
        }, $pilot->getRebelFaction()->statusSPCampaign);

        $this->assertCount(15, $scores);
        // we know this is a bad file and the scores are not consistent
        $this->assertEquals(1729938, $scoreSum);
        $this->assertNotEquals($scoreSum, max($bestScores));

        $this->assertFalse($pilot->hasValidCampaignData(), 'The campaign scores should not be valid');
    }

    public function testCanEditTheScores(): void
    {
        [, $pilot] = $this->loadFixture();
        $rebel = $pilot->faction[0];
        $rebel->missionSPCampaign[75]->bestScore = 153460;
        $rebel->missionSPCampaign[85]->bestScore = 211900;

        $scores = $pilot->getCompletedMissionScores(true);
        $scoreSum = array_sum($scores);
        $bestScores = array_map(static function ($campaign) {
            return $campaign->bestScore;
        }, $rebel->statusSPCampaign);

        $this->assertCount(15, $scores);
        $this->assertSame(2096418, $scoreSum);
        $this->assertSame($scoreSum, max($bestScores));

        file_put_contents($this->getEditFixturePath(), $pilot->toHexString());
    }

    public function testOutputMatchesInput(): void
    {
        [$hex, $pilot] = $this->loadFixture();
        $output = $pilot->toHexString();
        $differentBytes = 0;

        $this->assertSame(strlen($hex), strlen($output));

        for ($i = 0; $i < strlen($output); $i++) {
            if ($output[$i] !== $hex[$i]) {
                $differentBytes += 1;
            }
        }

        $this->assertLessThan(20, $differentBytes);
    }
}

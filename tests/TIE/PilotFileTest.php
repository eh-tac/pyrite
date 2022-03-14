<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PilotFileTest extends TestCase
{
    public function testSkillScore(): void
    {
        $dir = dirname(__FILE__);
        $contents = file_get_contents($dir . '/../data/TIETC19.tfr');
        $tie = new \Pyrite\TIE\PilotFile($contents);
        $this->assertEquals(65535, $tie->SkillScore);
    }
}

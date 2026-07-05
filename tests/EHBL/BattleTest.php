<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pyrite\EHBL\Battle;
use Pyrite\EHBL\BattleType;
use Pyrite\EHBL\Platform;

final class BattleTest extends TestCase
{
    public function testParseKeyReturnsPlatformTypeAndNumber(): void
    {
        [$platform, $type, $num] = Battle::parseKey('TIETC111');

        $this->assertSame(Platform::TIE, $platform);
        $this->assertSame(BattleType::TC, $type);
        $this->assertSame(111, $num);
    }

    public function testParseKeyPrefersLongestBattleTypePrefix(): void
    {
        [$platform, $type, $num] = Battle::parseKey('XvTFCHG7');

        $this->assertSame(Platform::XvT, $platform);
        $this->assertSame(BattleType::FCHG, $type);
        $this->assertSame(7, $num);
    }

    public function testParseKeyFreeMission(): void
    {
        [$platform, $type, $num] = Battle::parseKey('XWAF9');

        $this->assertSame(Platform::XWA, $platform);
        $this->assertSame(BattleType::FREE, $type);
        $this->assertSame(9, $num);
    }

    public function testParseXW(): void
    {
        [$platform, $type, $num] = Battle::parseKey('XWCMP3');

        $this->assertSame(Platform::XW, $platform);
        $this->assertSame(BattleType::CMP, $type);
        $this->assertSame(3, $num);
    }

    public function testParseKeyRejectsNonNumericSuffix(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to parse TIETCBAD as the battle name. Submissions must be in the format TIETC111');

        Battle::parseKey('TIETCBAD');
    }
}

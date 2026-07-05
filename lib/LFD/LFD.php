<?php

namespace Pyrite\LFD;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

class LFD extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    public string $HeaderType;
    public string $HeaderName;
    public int $HeaderLength;

    public function __construct(public string $hex, public ?PyriteModel $TIE = NULL)
    {
        parent::__construct($hex, $TIE);

        $this->HeaderType = $this->getChar($hex, 0, 4);
        $this->HeaderName = $this->getChar($hex, 4, 8);
        $this->HeaderLength = $this->getInt($hex, 12);
    }

    public function getLength(): int
    {
        return $this->HeaderLength;
    }

    public function __debugInfo(): array
    {
        return ['type' => $this->HeaderType, 'name' => $this->HeaderName, 'length' => $this->HeaderLength];
    }

    public static function fromHex(string $hex): LFD
    {
        $base = new LFD($hex);
        switch ($base->HeaderType) {
            case 'RMAP':
                return new RmapLFD($hex);
            case 'TEXT':
                return new TextLFD($hex);
        }
        return $base;
    }
}

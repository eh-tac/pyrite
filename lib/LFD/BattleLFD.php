<?php

namespace Pyrite\LFD;

use Pyrite\Hex;

class BattleLFD extends LFD
{
    public LFD $TextHeader;
    public LFD $DeltHeader;
    public BattleTextLFD $BattleText;
    public ?DeltLFD $MapDelt = null;

    public function __construct(string $hex = null, ?\Pyrite\PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
        $this->TextHeader = new LFD(substr($hex, 16, 16));
        $this->DeltHeader = new LFD(substr($hex, 32, 16));
        $this->BattleText = new BattleTextLFD(substr($hex, 48));
        //        $this->MapDelt = new DeltLFD(substr($hex, 64 + $this->BattleText->HeaderLength), $this->DeltHeader->HeaderLength);
    }

    public function __debugInfo(): array
    {
        return [
            'type' => $this->HeaderType,
            'name' => $this->HeaderName,
            'length' => $this->HeaderLength,
            'texthead' => $this->TextHeader,
            'delthead' => $this->DeltHeader,
            'text' => $this->BattleText,
            'delt' => $this->MapDelt
        ];
    }
}

<?php

namespace Pyrite\LFD;

use Pyrite\PyriteModel;

class RmapLFD extends LFD
{
    public array $SubHeaders = [];
    public array $Blocks = [];

    public function __construct(public string $hex, public ?PyriteModel $TIE = NULL)
    {
        parent::__construct($hex, $TIE);

        $off = 16;
        while ($off < $this->HeaderLength) {
            $this->SubHeaders[] = new LFD(substr($hex, $off, 16));
            $off += 16;
        }
    }

    public function __debugInfo(): array
    {
        return [
            'type' => $this->HeaderType,
            'name' => $this->HeaderName,
            'length' => $this->HeaderLength,
            'subheaders' => $this->SubHeaders,
            'blocks' => $this->Blocks
        ];
    }
}

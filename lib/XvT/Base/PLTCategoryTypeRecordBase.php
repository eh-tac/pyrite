<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTCategoryTypeRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTCATEGORYTYPERECORDLENGTH INT */
    public const PLTCATEGORYTYPERECORDLENGTH = 12;
    /** @var integer 0x0000 exercise INT */
    public $exercise;
    /** @var integer 0x0004 melee INT */
    public $melee;
    /** @var integer 0x0008 combat INT */
    public $combat;
    
    public function __construct($hex = null, $tie = null)
    {
        parent::__construct($hex, $tie);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex()
    {
        $hex = $this->hex;
        $offset = 0;

        $this->exercise = $this->getInt($hex, 0x0000);
        $this->melee = $this->getInt($hex, 0x0004);
        $this->combat = $this->getInt($hex, 0x0008);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "exercise" => $this->exercise,
            "melee" => $this->melee,
            "combat" => $this->combat
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->exercise, $hex, 0x0000);
        $hex = $this->writeInt($this->melee, $hex, 0x0004);
        $hex = $this->writeInt($this->combat, $hex, 0x0008);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTCATEGORYTYPERECORDLENGTH;
    }
}
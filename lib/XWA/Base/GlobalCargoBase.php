<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class GlobalCargoBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const GLOBALCARGOLENGTH = 140;
    /** @var string */
    public $Cargo;
    /** @var boolean */
    public $Unknown1;
    /** @var integer */
    public $Unknown2;
    /** @var integer */
    public $Unknown3;
    /** @var integer */
    public $Unknown4;
    /** @var integer */
    public $Unknown5;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Cargo = $this->getString($hex, 0x00);
        $this->Unknown1 = $this->getBool($hex, 0x44);
        $this->Unknown2 = $this->getByte($hex, 0x48);
        $this->Unknown3 = $this->getByte($hex, 0x49);
        $this->Unknown4 = $this->getByte($hex, 0x4A);
        $this->Unknown5 = $this->getByte($hex, 0x4B);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Cargo" => $this->Cargo,
            "Unknown1" => $this->Unknown1,
            "Unknown2" => $this->Unknown2,
            "Unknown3" => $this->Unknown3,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeString($hex, $this->Cargo, 0x00);
        $this->writeBool($hex, $this->Unknown1, 0x44);
        $this->writeByte($hex, $this->Unknown2, 0x48);
        $this->writeByte($hex, $this->Unknown3, 0x49);
        $this->writeByte($hex, $this->Unknown4, 0x4A);
        $this->writeByte($hex, $this->Unknown5, 0x4B);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::GLOBALCARGOLENGTH;
    }
}
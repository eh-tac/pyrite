<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PL2CampaignStatusSPRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PL2CAMPAIGNSTATUSSPRECORDLENGTH INT */
    public const PL2CAMPAIGNSTATUSSPRECORDLENGTH = 36;
    /** @var integer 0x0000 unknown0x0 INT */
    public $unknown0x0;
    /** @var integer 0x0004 isStartedUNK INT */
    public $isStartedUNK;
    /** @var integer 0x0008 missionNumber INT */
    public $missionNumber;
    /** @var integer 0x000C isFinished INT */
    public $isFinished;
    /** @var integer 0x0010 bestScore INT */
    public $bestScore;
    /** @var integer 0x0014 unknown0x14 INT */
    public $unknown0x14;
    /** @var integer 0x0018 unknown0x18 INT */
    public $unknown0x18;
    /** @var integer 0x001C unknown0x1C INT */
    public $unknown0x1C;
    /** @var integer 0x0020 unknown0x20 INT */
    public $unknown0x20;
    
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

        $this->unknown0x0 = $this->getInt($hex, 0x0000);
        $this->isStartedUNK = $this->getInt($hex, 0x0004);
        $this->missionNumber = $this->getInt($hex, 0x0008);
        $this->isFinished = $this->getInt($hex, 0x000C);
        $this->bestScore = $this->getInt($hex, 0x0010);
        $this->unknown0x14 = $this->getInt($hex, 0x0014);
        $this->unknown0x18 = $this->getInt($hex, 0x0018);
        $this->unknown0x1C = $this->getInt($hex, 0x001C);
        $this->unknown0x20 = $this->getInt($hex, 0x0020);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "unknown0x0" => $this->unknown0x0,
            "isStartedUNK" => $this->isStartedUNK,
            "missionNumber" => $this->missionNumber,
            "isFinished" => $this->isFinished,
            "bestScore" => $this->bestScore,
            "unknown0x14" => $this->unknown0x14,
            "unknown0x18" => $this->unknown0x18,
            "unknown0x1C" => $this->unknown0x1C,
            "unknown0x20" => $this->unknown0x20
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->unknown0x0, $hex, 0x0000);
        $hex = $this->writeInt($this->isStartedUNK, $hex, 0x0004);
        $hex = $this->writeInt($this->missionNumber, $hex, 0x0008);
        $hex = $this->writeInt($this->isFinished, $hex, 0x000C);
        $hex = $this->writeInt($this->bestScore, $hex, 0x0010);
        $hex = $this->writeInt($this->unknown0x14, $hex, 0x0014);
        $hex = $this->writeInt($this->unknown0x18, $hex, 0x0018);
        $hex = $this->writeInt($this->unknown0x1C, $hex, 0x001C);
        $hex = $this->writeInt($this->unknown0x20, $hex, 0x0020);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PL2CAMPAIGNSTATUSSPRECORDLENGTH;
    }
}
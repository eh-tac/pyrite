<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTTeamResultRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTTEAMRESULTRECORDLENGTH INT */
    public const PLTTEAMRESULTRECORDLENGTH = 28;
    /** @var integer 0x0000 totalMissionScore INT */
    public $totalMissionScore;
    /** @var integer 0x0004 isMissionComplete INT */
    public $isMissionComplete;
    /** @var integer 0x0008 unknown0x8 INT */
    public $unknown0x8;
    /** @var integer 0x000C timeMissionComplete INT */
    public $timeMissionComplete;
    /** @var integer 0x0010 fullKills INT */
    public $fullKills;
    /** @var integer 0x0014 sharedKills INT */
    public $sharedKills;
    /** @var integer 0x0018 losses INT */
    public $losses;
    
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

        $this->totalMissionScore = $this->getInt($hex, 0x0000);
        $this->isMissionComplete = $this->getInt($hex, 0x0004);
        $this->unknown0x8 = $this->getInt($hex, 0x0008);
        $this->timeMissionComplete = $this->getInt($hex, 0x000C);
        $this->fullKills = $this->getInt($hex, 0x0010);
        $this->sharedKills = $this->getInt($hex, 0x0014);
        $this->losses = $this->getInt($hex, 0x0018);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "totalMissionScore" => $this->totalMissionScore,
            "isMissionComplete" => $this->isMissionComplete,
            "unknown0x8" => $this->unknown0x8,
            "timeMissionComplete" => $this->timeMissionComplete,
            "fullKills" => $this->fullKills,
            "sharedKills" => $this->sharedKills,
            "losses" => $this->losses
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeInt($this->totalMissionScore, $hex, 0x0000);
        $hex = $this->writeInt($this->isMissionComplete, $hex, 0x0004);
        $hex = $this->writeInt($this->unknown0x8, $hex, 0x0008);
        $hex = $this->writeInt($this->timeMissionComplete, $hex, 0x000C);
        $hex = $this->writeInt($this->fullKills, $hex, 0x0010);
        $hex = $this->writeInt($this->sharedKills, $hex, 0x0014);
        $hex = $this->writeInt($this->losses, $hex, 0x0018);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTTEAMRESULTRECORDLENGTH;
    }
}
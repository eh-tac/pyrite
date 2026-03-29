<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PLTConnectedPlayerDataBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PLTCONNECTEDPLAYERDATALENGTH INT */
    public const PLTCONNECTEDPLAYERDATALENGTH = 88;
    /** @var string 0x0000 pilotLongNameUnused CHAR */
    public $pilotLongNameUnused;
    /** @var string 0x000E pilotShortName CHAR */
    public $pilotShortName;
    /** @var integer 0x001C fgIndex INT */
    public $fgIndex;
    /** @var integer 0x0020 DPPlayerID INT */
    public $DPPlayerID;
    /** @var integer 0x0024 pilotRank INT */
    public $pilotRank;
    /** @var integer 0x0028 playerScore INT */
    public $playerScore;
    /** @var integer 0x002C fullKills INT */
    public $fullKills;
    /** @var integer 0x0030 sharedKills INT */
    public $sharedKills;
    /** @var integer 0x0034 unusedInspections INT */
    public $unusedInspections;
    /** @var integer 0x0038 assistKills INT */
    public $assistKills;
    /** @var integer 0x003C losses INT */
    public $losses;
    /** @var integer 0x0040 craftType INT */
    public $craftType;
    /** @var integer 0x0044 optionalCraftIndex INT */
    public $optionalCraftIndex;
    /** @var integer 0x0048 optionalWarhead INT */
    public $optionalWarhead;
    /** @var integer 0x004C optionalBeam INT */
    public $optionalBeam;
    /** @var integer 0x0050 optionalCountermeasure INT */
    public $optionalCountermeasure;
    /** @var integer 0x0054 hasDisconnectedFromHostUNK INT */
    public $hasDisconnectedFromHostUNK;
    
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

        $this->pilotLongNameUnused = $this->getChar($hex, 0x0000, 14);
        $this->pilotShortName = $this->getChar($hex, 0x000E, 14);
        $this->fgIndex = $this->getInt($hex, 0x001C);
        $this->DPPlayerID = $this->getInt($hex, 0x0020);
        $this->pilotRank = $this->getInt($hex, 0x0024);
        $this->playerScore = $this->getInt($hex, 0x0028);
        $this->fullKills = $this->getInt($hex, 0x002C);
        $this->sharedKills = $this->getInt($hex, 0x0030);
        $this->unusedInspections = $this->getInt($hex, 0x0034);
        $this->assistKills = $this->getInt($hex, 0x0038);
        $this->losses = $this->getInt($hex, 0x003C);
        $this->craftType = $this->getInt($hex, 0x0040);
        $this->optionalCraftIndex = $this->getInt($hex, 0x0044);
        $this->optionalWarhead = $this->getInt($hex, 0x0048);
        $this->optionalBeam = $this->getInt($hex, 0x004C);
        $this->optionalCountermeasure = $this->getInt($hex, 0x0050);
        $this->hasDisconnectedFromHostUNK = $this->getInt($hex, 0x0054);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "pilotLongNameUnused" => $this->pilotLongNameUnused,
            "pilotShortName" => $this->pilotShortName,
            "fgIndex" => $this->fgIndex,
            "DPPlayerID" => $this->DPPlayerID,
            "pilotRank" => $this->pilotRank,
            "playerScore" => $this->playerScore,
            "fullKills" => $this->fullKills,
            "sharedKills" => $this->sharedKills,
            "unusedInspections" => $this->unusedInspections,
            "assistKills" => $this->assistKills,
            "losses" => $this->losses,
            "craftType" => $this->craftType,
            "optionalCraftIndex" => $this->optionalCraftIndex,
            "optionalWarhead" => $this->optionalWarhead,
            "optionalBeam" => $this->optionalBeam,
            "optionalCountermeasure" => $this->optionalCountermeasure,
            "hasDisconnectedFromHostUNK" => $this->hasDisconnectedFromHostUNK
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->pilotLongNameUnused, $hex, 0x0000);
        $hex = $this->writeChar($this->pilotShortName, $hex, 0x000E);
        $hex = $this->writeInt($this->fgIndex, $hex, 0x001C);
        $hex = $this->writeInt($this->DPPlayerID, $hex, 0x0020);
        $hex = $this->writeInt($this->pilotRank, $hex, 0x0024);
        $hex = $this->writeInt($this->playerScore, $hex, 0x0028);
        $hex = $this->writeInt($this->fullKills, $hex, 0x002C);
        $hex = $this->writeInt($this->sharedKills, $hex, 0x0030);
        $hex = $this->writeInt($this->unusedInspections, $hex, 0x0034);
        $hex = $this->writeInt($this->assistKills, $hex, 0x0038);
        $hex = $this->writeInt($this->losses, $hex, 0x003C);
        $hex = $this->writeInt($this->craftType, $hex, 0x0040);
        $hex = $this->writeInt($this->optionalCraftIndex, $hex, 0x0044);
        $hex = $this->writeInt($this->optionalWarhead, $hex, 0x0048);
        $hex = $this->writeInt($this->optionalBeam, $hex, 0x004C);
        $hex = $this->writeInt($this->optionalCountermeasure, $hex, 0x0050);
        $hex = $this->writeInt($this->hasDisconnectedFromHostUNK, $hex, 0x0054);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PLTCONNECTEDPLAYERDATALENGTH;
    }
}
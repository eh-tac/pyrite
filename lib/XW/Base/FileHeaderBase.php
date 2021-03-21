<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class FileHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FILEHEADERLENGTH = 206;
    /** @var integer */
    public $Version;
    /** @var integer */
    public $TimeLimit; //in minutes
    /** @var integer */
    public $EndState;
    /** @var integer */
    public const Reserved = 0;
    /** @var integer */
    public $MissionLocation;
    /** @var string[] */
    public $CompletionMessage;
    /** @var integer */
    public $NumFGs;
    /** @var integer */
    public $NumObj;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Version = $this->getShort($hex, 0x00);
        $this->TimeLimit = $this->getShort($hex, 0x02);
        $this->EndState = $this->getShort($hex, 0x04);
        // static SHORT value Reserved = 0
        $this->MissionLocation = $this->getShort($hex, 0x08);
        $this->CompletionMessage = [];
        $offset = 0x0A;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getString($hex, $offset);
            $this->CompletionMessage[] = $t;
            $offset += strlen($t);
        }
        $this->NumFGs = $this->getShort($hex, 0xCA);
        $this->NumObj = $this->getShort($hex, 0xCC);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Version" => $this->Version,
            "TimeLimit" => $this->TimeLimit,
            "EndState" => $this->getEndStateLabel(),
            "MissionLocation" => $this->getMissionLocationLabel(),
            "CompletionMessage" => $this->CompletionMessage,
            "NumFGs" => $this->NumFGs,
            "NumObj" => $this->NumObj
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Version, 0x00);
        $this->writeShort($hex, $this->TimeLimit, 0x02);
        $this->writeShort($hex, $this->EndState, 0x04);
        $this->writeShort($hex, 0, 0x06);
        $this->writeShort($hex, $this->MissionLocation, 0x08);
        $offset = 0x0A;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->CompletionMessage[$i];
            $this->writeString($hex, $t, $offset);
            $offset += strlen($t);
        }
        $this->writeShort($hex, $this->NumFGs, 0xCA);
        $this->writeShort($hex, $this->NumObj, 0xCC);

        return $hex;
    }
    
    public function getEndStateLabel() {
        return isset($this->EndState) && isset(Constants::$ENDSTATE[$this->EndState]) ? Constants::$ENDSTATE[$this->EndState] : "Unknown";
    }

    public function getMissionLocationLabel() {
        return isset($this->MissionLocation) && isset(Constants::$MISSIONLOCATION[$this->MissionLocation]) ? Constants::$MISSIONLOCATION[$this->MissionLocation] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FILEHEADERLENGTH;
    }
}
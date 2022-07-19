<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\Constants;

abstract class FileHeaderBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  FILEHEADERLENGTH INT */
    public const FILEHEADERLENGTH = 206;
    /** @var integer 0x00 Version SHORT */
    public $Version;
    /** @var integer 0x02 TimeLimit SHORT */
    public $TimeLimit; //in minutes
    /** @var integer 0x04 EndState SHORT */
    public $EndState;
    /** @var integer 0x06 Reserved SHORT */
    public const Reserved = 0;
    /** @var integer 0x08 MissionLocation SHORT */
    public $MissionLocation;
    /** @var string[] 0x0A CompletionMessage STR */
    public $CompletionMessage;
    /** @var integer 0xCA NumFGs SHORT */
    public $NumFGs;
    /** @var integer 0xCC NumObj SHORT */
    public $NumObj;
    
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
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Version, $hex, 0x00);
        $hex = $this->writeShort($this->TimeLimit, $hex, 0x02);
        $hex = $this->writeShort($this->EndState, $hex, 0x04);
        $hex = $this->writeShort(0, $hex, 0x06);
        $hex = $this->writeShort($this->MissionLocation, $hex, 0x08);
        $offset = 0x0A;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->CompletionMessage[$i];
            $hex = $this->writeString($t, $hex, $offset);
            $offset += strlen($t);
        }
        $hex = $this->writeShort($this->NumFGs, $hex, 0xCA);
        $hex = $this->writeShort($this->NumObj, $hex, 0xCC);

        return $hex;
    }
    
    public function getEndStateLabel() 
    {
        return isset($this->EndState) && isset(Constants::$ENDSTATE[$this->EndState]) ? Constants::$ENDSTATE[$this->EndState] : "Unknown";
    }

    public function getMissionLocationLabel() 
    {
        return isset($this->MissionLocation) && isset(Constants::$MISSIONLOCATION[$this->MissionLocation]) ? Constants::$MISSIONLOCATION[$this->MissionLocation] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FILEHEADERLENGTH;
    }
}
<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\FileHeader;
use Pyrite\XW\FlightGroup;
use Pyrite\XW\ObjectGroup;

abstract class MissionBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  MissionLength INT */
    public $MissionLength;
    /** @var FileHeader 0x00 FileHeader FileHeader */
    public $FileHeader;
    /** @var FlightGroup[] 0xCE FlightGroups FlightGroup */
    public $FlightGroups;
    /** @var ObjectGroup[] PV ObjectGroups ObjectGroup */
    public $ObjectGroups;
    
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

        $this->FileHeader = (new FileHeader(substr($hex, 0x00), $this->TIE))->loadHex();
        $this->FlightGroups = [];
        $offset = 0xCE;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = (new FlightGroup(substr($hex, $offset), $this->TIE))->loadHex();
            $this->FlightGroups[] = $t;
            $offset += $t->getLength();
        }
        $this->ObjectGroups = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumObj; $i++) {
            $t = (new ObjectGroup(substr($hex, $offset), $this->TIE))->loadHex();
            $this->ObjectGroups[] = $t;
            $offset += $t->getLength();
        }
        $this->MissionLength = $offset;
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "FileHeader" => $this->FileHeader,
            "FlightGroups" => $this->FlightGroups,
            "ObjectGroups" => $this->ObjectGroups
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->FileHeader, $hex, 0x00);
        $offset = 0xCE;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = $this->FlightGroups[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumObj; $i++) {
            $t = $this->ObjectGroups[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->MissionLength;
    }
}
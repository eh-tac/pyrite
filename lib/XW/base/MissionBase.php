<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XW\FileHeader;
use Pyrite\XW\FlightGroup;
use Pyrite\XW\ObjectGroup;

abstract class MissionBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $MissionLength;
    /** @var FileHeader */
    public $FileHeader;
    /** @var FlightGroup[] */
    public $FlightGroups;
    /** @var ObjectGroup[] */
    public $ObjectGroups;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->FileHeader = new FileHeader(substr($hex, 0x00), $this->TIE);
        $this->FlightGroups = [];
        $offset = 0xCE;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = new FlightGroup(substr($hex, $offset), $this->TIE);
            $this->FlightGroups[] = $t;
            $offset += $t->getLength();
        }
        $this->ObjectGroups = [];
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumObj; $i++) {
            $t = new ObjectGroup(substr($hex, $offset), $this->TIE);
            $this->ObjectGroups[] = $t;
            $offset += $t->getLength();
        }
        $this->MissionLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "FileHeader" => $this->FileHeader,
            "FlightGroups" => $this->FlightGroups,
            "ObjectGroups" => $this->ObjectGroups
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeObject($hex, $this->FileHeader, 0x00);
        $offset = 0xCE;
        for ($i = 0; $i < $this->FileHeader->NumFGs; $i++) {
            $t = $this->FlightGroups[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < $this->FileHeader->NumObj; $i++) {
            $t = $this->ObjectGroups[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->MissionLength;
    }
}
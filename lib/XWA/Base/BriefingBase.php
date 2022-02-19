<?php

namespace Pyrite\XWA\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XWA\LengthString;

abstract class BriefingBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $BriefingLength;
    /** @var integer */
    public $RunningTime;
    /** @var integer */
    public $Unknown1;
    /** @var integer */
    public $StartLength;
    /** @var integer */
    public $EventsLength;
    /** @var LengthString[] */
    public $Unnamed;
    /** @var boolean[] */
    public $ShowToTeams;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->RunningTime = $this->getShort($hex, 0x0000);
        $this->Unknown1 = $this->getShort($hex, 0x0002);
        $this->StartLength = $this->getShort($hex, 0x0004);
        $this->EventsLength = $this->getInt($hex, 0x0006);
        $this->Unnamed = [];
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = new LengthString(substr($hex, $offset), $this->TIE);
            $this->Unnamed[] = $t;
            $offset += $t->getLength();
        }
        $this->ShowToTeams = [];
        $offset = 0x440A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getBool($hex, $offset);
            $this->ShowToTeams[] = $t;
            $offset += 1;
        }
        $this->BriefingLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "RunningTime" => $this->RunningTime,
            "Unknown1" => $this->Unknown1,
            "StartLength" => $this->StartLength,
            "EventsLength" => $this->EventsLength,
            "Unnamed" => $this->Unnamed,
            "ShowToTeams" => $this->ShowToTeams
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->RunningTime, 0x0000);
        $this->writeShort($hex, $this->Unknown1, 0x0002);
        $this->writeShort($hex, $this->StartLength, 0x0004);
        $this->writeInt($hex, $this->EventsLength, 0x0006);
        $offset = $offset;
        for ($i = 0; $i < 128; $i++) {
            $t = $this->Unnamed[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x440A;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->ShowToTeams[$i];
            $this->writeBool($hex, $t, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    
    public function getLength()
    {
        return $this->BriefingLength;
    }
}
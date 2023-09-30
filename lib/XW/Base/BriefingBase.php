<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XW\BriefingHeader;
use Pyrite\XW\Coordinate;
use Pyrite\XW\Icon;
use Pyrite\XW\MissionHeader;
use Pyrite\XW\Page;
use Pyrite\XW\String;
use Pyrite\XW\Tag;
use Pyrite\XW\ViewportSetting;

abstract class BriefingBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  BriefingLength INT */
    public $BriefingLength;
    /** @var BriefingHeader 0x00 BriefingHeader BriefingHeader */
    public $BriefingHeader;
    /** @var Coordinate[] 0x6 CoordinateSet Coordinate */
    public $CoordinateSet;
    /** @var Icon[] PV IconSet Icon */
    public $IconSet;
    /** @var integer PV WindowSettingsCount SHORT */
    public $WindowSettingsCount;
    /** @var ViewportSetting[] PV Viewports ViewportSetting */
    public $Viewports;
    /** @var integer PV PageCount SHORT */
    public $PageCount;
    /** @var Page[] PV Pages Page */
    public $Pages;
    /** @var MissionHeader PV MissionHeader MissionHeader */
    public $MissionHeader;
    /** @var integer[] PV IconExtraData BYTE */
    public $IconExtraData;
    /** @var Tag PV Tags Tag */
    public $Tags;
    /** @var String PV Strings String */
    public $Strings;
    
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

        $this->BriefingHeader = (new BriefingHeader(substr($hex, 0x00), $this->TIE))->loadHex();
        $this->CoordinateSet = [];
        $offset = 0x6;
        for ($i = 0; $i < $this->CoordinateCount(); $i++) {
            $t = (new Coordinate(substr($hex, $offset), $this->TIE))->loadHex();
            $this->CoordinateSet[] = $t;
            $offset += $t->getLength();
        }
        $this->IconSet = [];
        $offset = $offset;
        for ($i = 0; $i < $this->BriefingHeader->IconCount; $i++) {
            $t = (new Icon(substr($hex, $offset), $this->TIE))->loadHex();
            $this->IconSet[] = $t;
            $offset += $t->getLength();
        }
        $this->WindowSettingsCount = $this->getShort($hex, $offset);
        $this->Viewports = [];
        $offset = $offset;
        for ($i = 0; $i < $this->ViewportCount(); $i++) {
            $t = (new ViewportSetting(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Viewports[] = $t;
            $offset += $t->getLength();
        }
        $this->PageCount = $this->getShort($hex, $offset);
        $this->Pages = [];
        $offset = $offset;
        for ($i = 0; $i < $this->PageCount; $i++) {
            $t = (new Page(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Pages[] = $t;
            $offset += $t->getLength();
        }
        $this->MissionHeader = (new MissionHeader(substr($hex, $offset), $this->TIE))->loadHex();
        $this->IconExtraData = [];
        $offset = $offset;
        for ($i = 0; $i < $this->BriefingHeader->IconCount; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->IconExtraData[] = $t;
            $offset += 90;
        }
        $this->Tags = (new Tag(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->Tags->getLength();
        $this->Strings = (new String(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->Strings->getLength();
        $this->BriefingLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "BriefingHeader" => $this->BriefingHeader,
            "CoordinateSet" => $this->CoordinateSet,
            "IconSet" => $this->IconSet,
            "WindowSettingsCount" => $this->WindowSettingsCount,
            "Viewports" => $this->Viewports,
            "PageCount" => $this->PageCount,
            "Pages" => $this->Pages,
            "MissionHeader" => $this->MissionHeader,
            "IconExtraData" => $this->IconExtraData,
            "Tags" => $this->Tags,
            "Strings" => $this->Strings
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->BriefingHeader, $hex, 0x00);
        $offset = 0x6;
        for ($i = 0; $i < $this->CoordinateCount(); $i++) {
            $t = $this->CoordinateSet[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = $offset;
        for ($i = 0; $i < $this->BriefingHeader->IconCount; $i++) {
            $t = $this->IconSet[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeShort($this->WindowSettingsCount, $hex, $offset);
        $offset = $offset;
        for ($i = 0; $i < $this->ViewportCount(); $i++) {
            $t = $this->Viewports[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeShort($this->PageCount, $hex, $offset);
        $offset = $offset;
        for ($i = 0; $i < $this->PageCount; $i++) {
            $t = $this->Pages[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeObject($this->MissionHeader, $hex, $offset);
        $offset = $offset;
        for ($i = 0; $i < $this->BriefingHeader->IconCount; $i++) {
            $t = $this->IconExtraData[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 90;
        }
        $hex = $this->writeObject($this->Tags, $hex, $offset);
        $hex = $this->writeObject($this->Strings, $hex, $offset);

        return $hex;
    }
    
    protected abstract function CoordinateCount();
protected abstract function ViewportCount();
    public function getLength()
    {
        return $this->BriefingLength;
    }
}
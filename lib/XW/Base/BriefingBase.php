<?php

namespace Pyrite\XW\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XW\BriefingHeader;
use Pyrite\XW\Coordinate;
use Pyrite\XW\Icon;
use Pyrite\XW\MissionHeader;
use Pyrite\XW\Page;
use Pyrite\XW\Tag;
use Pyrite\XW\ViewportSetting;
use Pyrite\XW\XWString;

abstract class BriefingBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int BriefingLength INT */
	public int $BriefingLength;
    /** @var BriefingHeader 0x00 BriefingHeader BriefingHeader */
	public BriefingHeader $BriefingHeader;
    /** @var array<Coordinate> 0x6 CoordinateSet Coordinate */
	public array $CoordinateSet;
    /** @var array<Icon> PV IconSet Icon */
	public array $IconSet;
    /** @var int PV WindowSettingsCount SHORT */
	public int $WindowSettingsCount;
    /** @var array<ViewportSetting> PV Viewports ViewportSetting */
	public array $Viewports;
    /** @var int PV PageCount SHORT */
	public int $PageCount;
    /** @var array<Page> PV Pages Page */
	public array $Pages;
    /** @var MissionHeader PV MissionHeader MissionHeader */
	public MissionHeader $MissionHeader;
    /** @var array<int> PV IconExtraData BYTE */
	public array $IconExtraData;
    /** @var Tag PV Tags Tag */
	public Tag $Tags;
    /** @var XWString PV Strings XWString */
	public XWString $Strings;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
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
        for ($i = 0; $i < $this->WindowSettingsCount; $i++) {
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
        $this->Strings = (new XWString(substr($hex, $offset), $this->TIE))->loadHex();
        $offset += $this->Strings->getLength();
        $this->BriefingLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        $this->afterLoadHex();
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
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
        for ($i = 0; $i < $this->WindowSettingsCount; $i++) {
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
    public function getLength(): int
    {
        return $this->BriefingLength;
    }
}
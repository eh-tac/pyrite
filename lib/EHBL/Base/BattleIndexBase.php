<?php

namespace Pyrite\EHBL\Base;

use Pyrite\Byteable;
use Pyrite\EHBL\Constants;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class BattleIndexBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  BattleIndexLength INT */
    public $BattleIndexLength;
    /** @var integer 0x00 Platform BYTE */
    public $Platform;
    /** @var integer 0x01 EncryptionOffset BYTE */
    public $EncryptionOffset;
    /** @var string 0x02 Title STR */
    public $Title;
    /** @var integer 0x35 MissionCount BYTE */
    public $MissionCount;
    /** @var integer 0x36 Unknown1 BYTE */
    public $Unknown1;
    /** @var string[] 0x37 MissionFilenames CHAR */
    public $MissionFilenames;
    /** @var integer PV Unknown2 BYTE */
    public $Unknown2;
    /** @var integer PV Unknown3 BYTE */
    public $Unknown3;
    /** @var integer PV Unknown4 BYTE */
    public $Unknown4;
    /** @var integer PV Reserved1 BYTE */
    public const Reserved1 = 1;
    /** @var integer PV Reserved2 BYTE */
    public const Reserved2 = 0;
    /** @var integer PV Unknown5 BYTE */
    public $Unknown5;
    /** @var integer PV Unknown6 BYTE */
    public $Unknown6;
    /** @var integer PV Reserved3 BYTE */
    public const Reserved3 = 1;
    /** @var integer PV Reserved4 BYTE */
    public const Reserved4 = 0;
    /** @var integer PV BattleNumber BYTE */
    public $BattleNumber;
    /** @var integer PV Reserved5 BYTE */
    public const Reserved5 = 0;
    
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

        $this->Platform = $this->getByte($hex, 0x00);
        $this->EncryptionOffset = $this->getByte($hex, 0x01);
        $this->Title = $this->getString($hex, 0x02);
        $this->MissionCount = $this->getByte($hex, 0x35);
        $this->Unknown1 = $this->getByte($hex, 0x36);
        $this->MissionFilenames = [];
        $offset = 0x37;
        for ($i = 0; $i < $this->MissionCount; $i++) {
            $t = $this->getChar($hex, $offset, 21);
            $this->MissionFilenames[] = $t;
            $offset += 21;
        }
        $this->Unknown2 = $this->getByte($hex, $offset);
        $offset += 1;
        $this->Unknown3 = $this->getByte($hex, $offset);
        $offset += 1;
        $this->Unknown4 = $this->getByte($hex, $offset);
        $offset += 1;
        // static BYTE value Reserved1 = 1
        $offset += 1;
        // static BYTE value Reserved2 = 0
        $offset += 1;
        $this->Unknown5 = $this->getByte($hex, $offset);
        $offset += 1;
        $this->Unknown6 = $this->getByte($hex, $offset);
        $offset += 1;
        // static BYTE value Reserved3 = 1
        $offset += 1;
        // static BYTE value Reserved4 = 0
        $offset += 1;
        $this->BattleNumber = $this->getByte($hex, $offset);
        $offset += 1;
        // static BYTE value Reserved5 = 0
        $offset += 1;
        $this->BattleIndexLength = $offset;
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Platform" => $this->getPlatformLabel(),
            "EncryptionOffset" => $this->EncryptionOffset,
            "Title" => $this->Title,
            "MissionCount" => $this->MissionCount,
            "Unknown1" => $this->Unknown1,
            "MissionFilenames" => $this->MissionFilenames,
            "Unknown2" => $this->Unknown2,
            "Unknown3" => $this->Unknown3,
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5,
            "Unknown6" => $this->Unknown6,
            "BattleNumber" => $this->BattleNumber
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeByte($this->Platform, $hex, 0x00);
        [$hex, $offset] = $this->writeByte($this->EncryptionOffset, $hex, 0x01);
        [$hex, $offset] = $this->writeString($this->Title, $hex, 0x02);
        [$hex, $offset] = $this->writeByte($this->MissionCount, $hex, 0x35);
        [$hex, $offset] = $this->writeByte($this->Unknown1, $hex, 0x36);
        $offset = 0x37;
        for ($i = 0; $i < $this->MissionCount; $i++) {
            $t = $this->MissionFilenames[$i];
            [$hex, $offset] = $this->writeChar($t, $hex, $offset);
        }
        [$hex, $offset] = $this->writeByte($this->Unknown2, $hex, $offset);
        [$hex, $offset] = $this->writeByte($this->Unknown3, $hex, $offset);
        [$hex, $offset] = $this->writeByte($this->Unknown4, $hex, $offset);
        [$hex, $offset] = $this->writeByte(1, $hex, $offset);
        [$hex, $offset] = $this->writeByte(0, $hex, $offset);
        [$hex, $offset] = $this->writeByte($this->Unknown5, $hex, $offset);
        [$hex, $offset] = $this->writeByte($this->Unknown6, $hex, $offset);
        [$hex, $offset] = $this->writeByte(1, $hex, $offset);
        [$hex, $offset] = $this->writeByte(0, $hex, $offset);
        [$hex, $offset] = $this->writeByte($this->BattleNumber, $hex, $offset);
        [$hex, $offset] = $this->writeByte(0, $hex, $offset);

        return $hex;
    }
    
    public function getPlatformLabel() 
    {
        return isset($this->Platform) && isset(Constants::$PLATFORM[$this->Platform]) ? Constants::$PLATFORM[$this->Platform] : "Unknown";
    }
    
    public function getLength()
    {
        return $this->BattleIndexLength;
    }
}
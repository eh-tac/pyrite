<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\PLTAIRankCountRecord;
use Pyrite\XvT\PLTCategoryTypeRecord;
use Pyrite\XvT\PLTPlayerRankCountRecord;

abstract class PL2DebriefRecordBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PL2DEBRIEFRECORDLENGTH INT */
    public const PL2DEBRIEFRECORDLENGTH = 5256;
    /** @var PLTCategoryTypeRecord 0x0000 UnknownRecord1 PLTCategoryTypeRecord */
    public $UnknownRecord1;
    /** @var PLTCategoryTypeRecord 0x000C UnknownRecord2 PLTCategoryTypeRecord */
    public $UnknownRecord2;
    /** @var PLTCategoryTypeRecord 0x0018 UnknownRecord3 PLTCategoryTypeRecord */
    public $UnknownRecord3;
    /** @var PLTCategoryTypeRecord 0x0024 enemyKillsEXX PLTCategoryTypeRecord */
    public $enemyKillsEXX;
    /** @var PLTCategoryTypeRecord 0x0030 friendlyKillsEXX PLTCategoryTypeRecord */
    public $friendlyKillsEXX;
    /** @var integer[] 0x003C totalKillCountByCraftType INT */
    public $totalKillCountByCraftType;
    /** @var PLTPlayerRankCountRecord 0x0E4C FullKillsOnPlayerRank PLTPlayerRankCountRecord */
    public $FullKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x0F78 SharedKillsOnPlayerRank PLTPlayerRankCountRecord */
    public $SharedKillsOnPlayerRank;
    /** @var PLTPlayerRankCountRecord 0x10A4 AssistKillsOnPlayerRank PLTPlayerRankCountRecord */
    public $AssistKillsOnPlayerRank;
    /** @var PLTAIRankCountRecord 0x11D0 FullKillsOnAIRank PLTAIRankCountRecord */
    public $FullKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x1218 SharedKillsOnAIRank PLTAIRankCountRecord */
    public $SharedKillsOnAIRank;
    /** @var PLTAIRankCountRecord 0x1260 AssistKillsOnAIRank PLTAIRankCountRecord */
    public $AssistKillsOnAIRank;
    /** @var PLTCategoryTypeRecord 0x12A8 NumHiddenCargoFoundEXX PLTCategoryTypeRecord */
    public $NumHiddenCargoFoundEXX;
    /** @var PLTCategoryTypeRecord 0x12B4 NumCannonHitsEXX PLTCategoryTypeRecord */
    public $NumCannonHitsEXX;
    /** @var PLTCategoryTypeRecord 0x12C0 NumCannonFiredEXX PLTCategoryTypeRecord */
    public $NumCannonFiredEXX;
    /** @var PLTCategoryTypeRecord 0x12CC NumWarheadHitsEXX PLTCategoryTypeRecord */
    public $NumWarheadHitsEXX;
    /** @var PLTCategoryTypeRecord 0x12D8 NumWarheadFiredEXX PLTCategoryTypeRecord */
    public $NumWarheadFiredEXX;
    /** @var PLTCategoryTypeRecord 0x12E4 NumCraftLossesEXX PLTCategoryTypeRecord */
    public $NumCraftLossesEXX;
    /** @var PLTCategoryTypeRecord 0x12F0 CraftLossesFromCollisionEXX PLTCategoryTypeRecord */
    public $CraftLossesFromCollisionEXX;
    /** @var PLTCategoryTypeRecord 0x12FC CraftLossesFromStarshipEXX PLTCategoryTypeRecord */
    public $CraftLossesFromStarshipEXX;
    /** @var PLTCategoryTypeRecord 0x1308 CraftLossesFromMineEXX PLTCategoryTypeRecord */
    public $CraftLossesFromMineEXX;
    /** @var PLTPlayerRankCountRecord 0x1314 LossesFromPlayerRank PLTPlayerRankCountRecord */
    public $LossesFromPlayerRank;
    /** @var PLTAIRankCountRecord 0x1440 LossesFromAIRank PLTAIRankCountRecord */
    public $LossesFromAIRank;
    
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

        $this->UnknownRecord1 = (new PLTCategoryTypeRecord(substr($hex, 0x0000), $this->TIE))->loadHex();
        $this->UnknownRecord2 = (new PLTCategoryTypeRecord(substr($hex, 0x000C), $this->TIE))->loadHex();
        $this->UnknownRecord3 = (new PLTCategoryTypeRecord(substr($hex, 0x0018), $this->TIE))->loadHex();
        $this->enemyKillsEXX = (new PLTCategoryTypeRecord(substr($hex, 0x0024), $this->TIE))->loadHex();
        $this->friendlyKillsEXX = (new PLTCategoryTypeRecord(substr($hex, 0x0030), $this->TIE))->loadHex();
        $this->totalKillCountByCraftType = [];
        $offset = 0x003C;
        for ($i = 0; $i < 900; $i++) {
            $t = $this->getInt($hex, $offset);
            $this->totalKillCountByCraftType[] = $t;
            $offset += 4;
        }
        $this->FullKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x0E4C), $this->TIE))->loadHex();
        $this->SharedKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x0F78), $this->TIE))->loadHex();
        $this->AssistKillsOnPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x10A4), $this->TIE))->loadHex();
        $this->FullKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x11D0), $this->TIE))->loadHex();
        $this->SharedKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x1218), $this->TIE))->loadHex();
        $this->AssistKillsOnAIRank = (new PLTAIRankCountRecord(substr($hex, 0x1260), $this->TIE))->loadHex();
        $this->NumHiddenCargoFoundEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12A8), $this->TIE))->loadHex();
        $this->NumCannonHitsEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12B4), $this->TIE))->loadHex();
        $this->NumCannonFiredEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12C0), $this->TIE))->loadHex();
        $this->NumWarheadHitsEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12CC), $this->TIE))->loadHex();
        $this->NumWarheadFiredEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12D8), $this->TIE))->loadHex();
        $this->NumCraftLossesEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12E4), $this->TIE))->loadHex();
        $this->CraftLossesFromCollisionEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12F0), $this->TIE))->loadHex();
        $this->CraftLossesFromStarshipEXX = (new PLTCategoryTypeRecord(substr($hex, 0x12FC), $this->TIE))->loadHex();
        $this->CraftLossesFromMineEXX = (new PLTCategoryTypeRecord(substr($hex, 0x1308), $this->TIE))->loadHex();
        $this->LossesFromPlayerRank = (new PLTPlayerRankCountRecord(substr($hex, 0x1314), $this->TIE))->loadHex();
        $this->LossesFromAIRank = (new PLTAIRankCountRecord(substr($hex, 0x1440), $this->TIE))->loadHex();
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "UnknownRecord1" => $this->UnknownRecord1,
            "UnknownRecord2" => $this->UnknownRecord2,
            "UnknownRecord3" => $this->UnknownRecord3,
            "enemyKillsEXX" => $this->enemyKillsEXX,
            "friendlyKillsEXX" => $this->friendlyKillsEXX,
            "totalKillCountByCraftType" => $this->totalKillCountByCraftType,
            "FullKillsOnPlayerRank" => $this->FullKillsOnPlayerRank,
            "SharedKillsOnPlayerRank" => $this->SharedKillsOnPlayerRank,
            "AssistKillsOnPlayerRank" => $this->AssistKillsOnPlayerRank,
            "FullKillsOnAIRank" => $this->FullKillsOnAIRank,
            "SharedKillsOnAIRank" => $this->SharedKillsOnAIRank,
            "AssistKillsOnAIRank" => $this->AssistKillsOnAIRank,
            "NumHiddenCargoFoundEXX" => $this->NumHiddenCargoFoundEXX,
            "NumCannonHitsEXX" => $this->NumCannonHitsEXX,
            "NumCannonFiredEXX" => $this->NumCannonFiredEXX,
            "NumWarheadHitsEXX" => $this->NumWarheadHitsEXX,
            "NumWarheadFiredEXX" => $this->NumWarheadFiredEXX,
            "NumCraftLossesEXX" => $this->NumCraftLossesEXX,
            "CraftLossesFromCollisionEXX" => $this->CraftLossesFromCollisionEXX,
            "CraftLossesFromStarshipEXX" => $this->CraftLossesFromStarshipEXX,
            "CraftLossesFromMineEXX" => $this->CraftLossesFromMineEXX,
            "LossesFromPlayerRank" => $this->LossesFromPlayerRank,
            "LossesFromAIRank" => $this->LossesFromAIRank
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeObject($this->UnknownRecord1, $hex, 0x0000);
        $hex = $this->writeObject($this->UnknownRecord2, $hex, 0x000C);
        $hex = $this->writeObject($this->UnknownRecord3, $hex, 0x0018);
        $hex = $this->writeObject($this->enemyKillsEXX, $hex, 0x0024);
        $hex = $this->writeObject($this->friendlyKillsEXX, $hex, 0x0030);
        $offset = 0x003C;
        for ($i = 0; $i < 900; $i++) {
            $t = $this->totalKillCountByCraftType[$i];
            $hex = $this->writeInt($t, $hex, $offset);
            $offset += 4;
        }
        $hex = $this->writeObject($this->FullKillsOnPlayerRank, $hex, 0x0E4C);
        $hex = $this->writeObject($this->SharedKillsOnPlayerRank, $hex, 0x0F78);
        $hex = $this->writeObject($this->AssistKillsOnPlayerRank, $hex, 0x10A4);
        $hex = $this->writeObject($this->FullKillsOnAIRank, $hex, 0x11D0);
        $hex = $this->writeObject($this->SharedKillsOnAIRank, $hex, 0x1218);
        $hex = $this->writeObject($this->AssistKillsOnAIRank, $hex, 0x1260);
        $hex = $this->writeObject($this->NumHiddenCargoFoundEXX, $hex, 0x12A8);
        $hex = $this->writeObject($this->NumCannonHitsEXX, $hex, 0x12B4);
        $hex = $this->writeObject($this->NumCannonFiredEXX, $hex, 0x12C0);
        $hex = $this->writeObject($this->NumWarheadHitsEXX, $hex, 0x12CC);
        $hex = $this->writeObject($this->NumWarheadFiredEXX, $hex, 0x12D8);
        $hex = $this->writeObject($this->NumCraftLossesEXX, $hex, 0x12E4);
        $hex = $this->writeObject($this->CraftLossesFromCollisionEXX, $hex, 0x12F0);
        $hex = $this->writeObject($this->CraftLossesFromStarshipEXX, $hex, 0x12FC);
        $hex = $this->writeObject($this->CraftLossesFromMineEXX, $hex, 0x1308);
        $hex = $this->writeObject($this->LossesFromPlayerRank, $hex, 0x1314);
        $hex = $this->writeObject($this->LossesFromAIRank, $hex, 0x1440);

        return $hex;
    }
    
    
    public function getLength()
    {
        return self::PL2DEBRIEFRECORDLENGTH;
    }
}
<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class RoleBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const ROLELENGTH = 4;
    /** @var string */
    public $Team;
    /** @var string */
    public $Designation;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Team = $this->getChar($hex, 0x0, 1);
        $this->Designation = $this->getChar($hex, 0x1, 3);
        
    }
    
    public function __debugInfo()
    {
        return [
            "Team" => $this->Team,
            "Designation" => $this->getDesignationLabel()
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeChar($hex, $this->Team, 0x0);
        $this->writeChar($hex, $this->Designation, 0x1);

        return $hex;
    }
    
    public function getDesignationLabel() {
        return isset($this->Designation) && isset(Constants::$DESIGNATION[$this->Designation]) ? Constants::$DESIGNATION[$this->Designation] : "Unknown";
    }
    
    public function getLength()
    {
        return self::ROLELENGTH;
    }
}
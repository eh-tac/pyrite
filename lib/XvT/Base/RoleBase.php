<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;

abstract class RoleBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  ROLELENGTH INT */
    public const ROLELENGTH = 4;
    /** @var string 0x0 Team CHAR */
    public $Team;
    /** @var string 0x1 Designation CHAR */
    public $Designation;
    
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

        $this->Team = $this->getChar($hex, 0x0, 1);
        $this->Designation = $this->getChar($hex, 0x1, 3);
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Team" => $this->Team,
            "Designation" => $this->getDesignationLabel()
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeChar($this->Team, $hex, 0x0);
        $hex = $this->writeChar($this->Designation, $hex, 0x1);

        return $hex;
    }
    
    public function getDesignationLabel() 
    {
        return isset($this->Designation) && isset(Constants::$DESIGNATION[$this->Designation]) ? Constants::$DESIGNATION[$this->Designation] : "Unknown";
    }
    
    public function getLength()
    {
        return self::ROLELENGTH;
    }
}
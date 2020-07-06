<?php
namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class WayptBase extends PyriteBase implements Byteable {
	use HexDecoder;

	const WAYPT_LENGTH = 0x1E;

	/** @var \Pyrite\TIE\SHORT */
	public $StartPoints;
	/** @var \Pyrite\TIE\SHORT */
	public $Waypoints;
	/** @var \Pyrite\TIE\SHORT */
	public $Rendezvous;
	/** @var \Pyrite\TIE\SHORT */
	public $Hyperspace;
	/** @var \Pyrite\TIE\SHORT */
	public $Briefing;

	public function __construct($hex, $tie){
		$this->hex = $hex;
		$this->TIE = $tie; 
		$offset = 0;

        $this->StartPoints = [];
        $offset = 0x00;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->StartPoints[] = $t;
            $offset += 8;
        }

        $this->Waypoints = [];
        $offset = 0x08;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getShort($hex, $offset);
            $this->Waypoints[] = $t;
            $offset += 16;
        }
		$this->Rendezvous = $this->getShort($hex, 0x18);
		$this->Hyperspace = $this->getShort($hex, 0x1A);
		$this->Briefing = $this->getShort($hex, 0x1C);
		$this->afterConstruct();
	}

	public function __debugInfo() {
		return [
			"StartPoints" => $this->StartPoints,
			"Waypoints" => $this->Waypoints,
			"Rendezvous" => $this->Rendezvous,
			"Hyperspace" => $this->Hyperspace,
			"Briefing" => $this->Briefing		];
	}

	protected function toHexString() {

		$hex = "";

		$offset = 0;

        $offset = 0x00;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->StartPoints[$i];
            $this->writeShort($hex, $this->StartPoints[$i], $offset);
            $offset += 8;
        }

        $offset = 0x08;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Waypoints[$i];
            $this->writeShort($hex, $this->Waypoints[$i], $offset);
            $offset += 16;
        }
		$this->writeShort($hex, $this->Rendezvous, 0x18);
		$this->writeShort($hex, $this->Hyperspace, 0x1A);
		$this->writeShort($hex, $this->Briefing, 0x1C);
		return $hex;
	}


    public function getLength(){
        return self::WAYPT_LENGTH;
    }
}
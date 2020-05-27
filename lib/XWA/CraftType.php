<?php
namespace Pyrite\XWA;

class CraftType {
	public $ID;
	public $Name;
	public $Abbr;

	public function __construct($ID){
		$this->ID = $ID;
		$this->Name = $this->getName();
		$this->Abbr = $this->getAbbr();
	}

	private function getName(){
		return isset(Constants::$CRAFTTYPE[$this->ID])
			? Constants::$CRAFTTYPE[$this->ID]
			: "Unknown {$this->ID}";
	}

	private function getAbbr(){
		return isset(Constants::$CRAFTTYPE[$this->ID])
			? Constants::$CRAFTTYPE[$this->ID]
			: "Unknown {$this->ID}";
	}
}
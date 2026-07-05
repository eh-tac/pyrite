<?php

namespace Pyrite\EHBL;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

class BattleIndex extends PyriteBase implements Byteable, PyriteModel
{
	use HexDecoder;
	use HexEncoder;

	public int $platform;
	public int $encryptionOffset;
	public string $title;
	public array $missions = [];

	public function __construct(public string $key = '', public ?PyriteModel $TIE = null)
	{
		parent::__construct('', $TIE);
	}

	public static function fromHex(string $hex, string $key = ''): BattleIndex
	{
		$battle = (new BattleIndex($key))
			->setHex($hex);
		$battle = $battle
			->setPlatform($battle->getByte($hex, 0))
			->setOffset($battle->getByte($hex, 1))
			->setTitle($battle->getString($hex, 2, 50));

		$count = $battle->getByte($hex, 53);
		$rest  = substr($hex, 55);
		for ($m = 0; $m < $count; $m++) {
			$battle->addMission($battle->getString($rest, $m * 21, 21));
		}

		return $battle;
	}

	public function setHex($hex)
	{
		$this->hex = $hex;
		return $this;
	}

	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function setOffset($offset)
	{
		$this->encryptionOffset = $offset;
		return $this;
	}

	public function setPlatform($platform)
	{
		$this->platform = $platform;
		return $this;
	}

	public function addMission($mission)
	{
		$this->missions[] = $mission;
		return $this;
	}

	/**
	 * @param string   $key
	 * @param string   $title
	 * @param string[] $missions
	 * @param null     $offset
	 * @return BattleIndex
	 */
	public static function build($key = '', $title = '', $missions = [], $offset = NULL)
	{
		if ($offset === NULL) {
			$offset = rand(1, 255);
		}
		return (new BattleIndex($key))
			->setOffset($offset)
			->setTitle($title)
			->setMissions($missions);
	}

	public function setMissions($missions)
	{
		$this->missions = $missions;
		return $this;
	}

	public function getLength(): int
	{
		return count($this->missions) * 21 + 65;
	}

	public function toHexString($hex = null): string
	{
		$hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));

		$hex = $this->writeByte($this->platform, $hex, 0);
		$hex = $this->writeByte($this->encryptionOffset, $hex, 1);
		$hex = $this->writeString($this->title, $hex, 2);
		$hex = $this->writeByte(count($this->missions), $hex, 53);
		$off = 55;
		foreach ($this->missions as $mission) {
			$hex = $this->writeChar($mission, $hex, $off);
			$off += 21;
		}

		return $hex;
	}

	public function compareHex(string $otherHex): bool
	{
		$other = new BattleIndex($otherHex);
		return ($this->encryptionOffset === $other->encryptionOffset &&
			$this->title === $other->title &&
			$this->missions === $other->missions &&
			substr($this->hex, -4, 4) === substr($otherHex, -4, 4)
		);
	}

	public function __debugInfo(): array
	{
		return [
			"platform" => $this->platform,
			"key"      => $this->key,
			"offset"   => $this->encryptionOffset,
			"title"    => $this->title,
			"missions" => $this->missions,
		];
	}
}

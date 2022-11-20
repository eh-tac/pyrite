<?php

namespace Pyrite\EHBL;

class BattleIndex extends Base\BattleIndexBase
{
  public static function build($platform = 0, $title = '', $missions = [], $battleNumber = 0, $offset = NULL)
  {
    if ($offset === NULL) {
      $offset = rand(1, 255);
    }
    $bi = new BattleIndex('');
    $bi->Platform = $platform;
    $bi->EncryptionOffset = $offset;
    $bi->Title = $title;
    $bi->MissionFilenames = array_map(fn ($m) => str_pad($m, 21, chr(0)), $missions);
    $bi->MissionCount = count($missions);
    $bi->BattleNumber = $battleNumber;
    $bi->BattleIndexLength = count($missions) * 21 + 65;

    return $bi;
  }

  public static function fromHex($hex, $tie = null)
  {
    return (new BattleIndex($hex, $tie))->loadHex();
  }

  public function __toString()
  {
    return $this->title;
  }
}

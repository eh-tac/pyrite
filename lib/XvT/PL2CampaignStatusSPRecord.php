<?php

namespace Pyrite\XvT;

class PL2CampaignStatusSPRecord extends Base\PL2CampaignStatusSPRecordBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PL2CampaignStatusSPRecord
  {
    return (new PL2CampaignStatusSPRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}

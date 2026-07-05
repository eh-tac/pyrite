<?php

namespace Pyrite\XvT;

class PL2CampaignRecord extends Base\PL2CampaignRecordBase
{

  public static   function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PL2CampaignRecord
  {
    return (new PL2CampaignRecord($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}

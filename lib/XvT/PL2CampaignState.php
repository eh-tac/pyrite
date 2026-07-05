<?php

namespace Pyrite\XvT;

class PL2CampaignState extends Base\PL2CampaignStateBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PL2CampaignState
  {
    return (new PL2CampaignState($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}

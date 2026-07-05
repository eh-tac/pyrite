<?php

namespace Pyrite\XvT;

class PL2CampaignProgressState extends Base\PL2CampaignProgressStateBase
{

  public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = null): PL2CampaignProgressState
  {
    return (new PL2CampaignProgressState($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }
}

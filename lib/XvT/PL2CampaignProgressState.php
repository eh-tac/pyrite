<?php
namespace Pyrite\XvT;
    
class PL2CampaignProgressState extends Base\PL2CampaignProgressStateBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PL2CampaignProgressState($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}

<?php
namespace Pyrite\XvT;
    
class PL2CampaignState extends Base\PL2CampaignStateBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PL2CampaignState($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}

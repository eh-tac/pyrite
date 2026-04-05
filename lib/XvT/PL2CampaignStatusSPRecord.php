<?php
namespace Pyrite\XvT;
    
class PL2CampaignStatusSPRecord extends Base\PL2CampaignStatusSPRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PL2CampaignStatusSPRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}

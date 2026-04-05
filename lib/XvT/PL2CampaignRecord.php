<?php
namespace Pyrite\XvT;
    
class PL2CampaignRecord extends Base\PL2CampaignRecordBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PL2CampaignRecord($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}

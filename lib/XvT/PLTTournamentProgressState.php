<?php
namespace Pyrite\XvT;
    
class PLTTournamentProgressState extends Base\PLTTournamentProgressStateBase
{

    public static function fromHex($hex, $tie = null) {
      return (new PLTTournamentProgressState($hex, $tie))->loadHex();
    }

    public function __toString() 
    {
      return '';
    }

    
}

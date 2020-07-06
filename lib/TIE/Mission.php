<?php

namespace Pyrite\TIE;

class Mission extends Base\MissionBase
{
    public $valid = false;

    public function __construct($hex)
    {
        parent::__construct($hex, $this);
    }

    protected function afterConstruct()
    {
        $this->valid = true;
        $this->TIE = $this;
    }

    public function lookupIFF($iff)
    {
        $IFFs = ["Rebel", "Imperial"];
        if (isset($this->TIE)) {
            $IFFs = array_merge($IFFs, $this->FileHeader->OtherIffNames);
        }

        $iffName = isset($IFFs[$iff]) && trim($IFFs[$iff]) ? $IFFs[$iff] : "Unknown IFF ({$iff})";

        if (is_numeric($iffName[0])) {
            $iffName = substr($iffName, 1) . ' (hostile)';
        }

        return $iffName;
    }

    public function lookupGlobalGroup($gg)
    {
        return 'TODO ' . $gg;
    }

    public function validate(){
        $errors = [];
        foreach ($this->FlightGroups as $fg){
            if ($fg->isFriendly()){
                // TODO
            } else {
                if ($fg->ObeyPlayerOrders){
                    $errors[] = "Non-Imperial IFF $fg obeys radio orders";
                }
            }
        }
        return $errors;
    }

    public static function validHex($hex)
    {
        $plat = substr($hex, 0, 2);
        $p = unpack('sshort', $plat)['short'];
        return $p === FileHeader::PLATFORM_ID;
    }
}

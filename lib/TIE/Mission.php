<?php

namespace Pyrite\TIE;

class Mission extends Base\MissionBase
{
    public $valid = false;

    public function __construct($hex)
    {
        parent::__construct($hex, $this);
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

    public function validate()
    {
        $errors = [];
        foreach ($this->FlightGroups as $fg) {
            if ($fg->isFriendly()) {
                // TODO
            } else {
                if ($fg->ObeyPlayerOrders) {
                    $errors[] = "Non-Imperial IFF $fg obeys radio orders";
                }
            }
        }
        if (count($this->FlightGroups) > 48){
            $errors[] = "More than 48 flightgroups - " . count($this->FlightGroups);
            $errors[] = "Header count is " . $this->FileHeader->NumFGs;
        }
        foreach ($this->Briefing->getUsedTags() as $tag){
            if ($tag->Length > 40){
                $errors[] = "Tag {$tag->Text} is long {$tag->Length}";
            }
        }
        foreach ($this->Briefing->getUsedStrings() as $str){
            if ($str->Length > 160){
                $errors[] = "Briefing String {$str->Text} is long {$str->Length}";
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

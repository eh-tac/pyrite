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
        if (count($this->FlightGroups) > 48) {
            $errors[] = "More than 48 flightgroups - " . count($this->FlightGroups);
            $errors[] = "Header count is " . $this->FileHeader->NumFGs;
        }
        foreach ($this->Briefing->getUsedTags() as $tag) {
            if ($tag->Length > 40) {
                $errors[] = "Tag {$tag->Text} is long {$tag->Length}";
            }
        }
        foreach ($this->Briefing->getUsedStrings() as $str) {
            if ($str->Length > 160) {
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

    public function getPlayerFG()
    {
        foreach ($this->FlightGroups as $fg) {
            if ($fg->isPlayerCraft()) {
                return $fg;
            }
        }
    }

    public function requiresPatch(): bool
    {
        return $this->flyRebelFighters() || $this->flyTransports() || $this->usesSlots();
    }

    public function flyRebelFighters()
    {
        $rebelFighters = [
            Constants::$CRAFTABBR_XW,
            Constants::$CRAFTABBR_YW,
            Constants::$CRAFTABBR_AW,
            Constants::$CRAFTABBR_BW,
            Constants::$CRAFTABBR_TW,
            Constants::$CRAFTABBR_Z95,
            Constants::$CRAFTABBR_R41,
        ];
        if ($fg = $this->getPlayerFG()) {
            return in_array($fg->CraftType, $rebelFighters);
        }
        return false;
    }

    public function flyTransports()
    {
        $transports = [
            Constants::$CRAFTABBR_SHU,
            Constants::$CRAFTABBR_ES,
            Constants::$CRAFTABBR_TRN,
            Constants::$CRAFTABBR_ATR,
            Constants::$CRAFTABBR_ETR,
            Constants::$CRAFTABBR_MUTR,
            Constants::$CRAFTABBR_CORT,
        ];
        if ($fg = $this->getPlayerFG()) {
            return in_array($fg->CraftType, $transports);
        }
        return false;
    }

    public function usesSlots()
    {
        // use raw ids in case the lookups are renamed later
        $slots = [10, 11, 31, 36, 39, 54, 72, 73, 74, 78, 79, 82, 85];
        foreach ($this->FlightGroups as $fg) {
            if (in_array($fg->CraftType, $slots)) {
                return $fg;
            }
        }
        return false;
    }
}

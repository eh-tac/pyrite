<?php

namespace Pyrite\XW;

class FlightGroup extends Base\FlightGroupBase
{

    public function beforeConstruct()
    {
    }

    public function __toString()
    {
        $w = $this->NumberOfWaves + 1;
        $c = $this->NumberOfCraft;

        $t = $this->getCraftTypeLabel();
        $n = $this->Name;

        return "$w x $c $t $n";
    }

    public function isGoal() {
        return $this->CraftObjective;
    }

    public function goalLabel(){
        $a = $this->getArriveLabel();
        return $this . ' - must be ' . $this->getCraftObjectiveLabel() . ' ' . $a;
    }

    public function getArriveLabel(){
        if (!$this->ArrivalEvent && !$this->ArrivalDelay){
            return '';
        }
        $e = $this->getArrivalEventLabel();
        if ($this->ArrivalFlightGroup){
            $fg = $this->TIE->getFG($this->ArrivalFlightGroup);
            $e = $fg . ' - be ' . $e;
        }
        $d = $this->ArrivalDelay;
        if ($d){
            if ($d <= 20) {
                // If ArrivalDelay <= 20, the value is interpreted as minutes.
                $d .= 'm';
            } else {
                $d -= 20;
                // If ArrivalDelay > 20, subtract 20, then multiply the result by 6 seconds.
                $d *= 6;
                $d .= 's';
            }


        }
        return "arrives $d after $e";
    }


}

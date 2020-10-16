<?php
namespace Pyrite\XW;
    
class ObjectGroup extends Base\ObjectGroupBase
{

    public function beforeConstruct() {}

    public function __toString() 
    {
        $c = $this->NumberOfObjects;

        $t = 'Object ' . $this->ObjectType;
        $n = $this->Name;

        return "$c $t $n";

      return '';
    }

    public function isGoal(){
        return $this->Objective && $this->Objective !== 3;
    }

    public function goalLabel(){
        $o = $this->Objective;
        if ($o === 4){
            $o = 'destroyed';
        }

        return $this . ' - must be ' . $o;
    }

    
}

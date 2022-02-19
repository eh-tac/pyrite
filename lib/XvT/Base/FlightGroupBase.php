<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\XvT\Constants;
use Pyrite\XvT\GoalFG;
use Pyrite\XvT\Order;
use Pyrite\XvT\Role;
use Pyrite\XvT\Trigger;
use Pyrite\XvT\Waypt;

abstract class FlightGroupBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public const FLIGHTGROUPLENGTH = 1378;
    /** @var string */
    public $Name;
    /** @var Role[] */
    public $Roles;
    /** @var string */
    public $Cargo;
    /** @var string */
    public $SpecialCargo;
    /** @var integer */
    public $SpecialCargoCraft;
    /** @var boolean */
    public $RandomSpecialCargo;
    /** @var integer */
    public $CraftType;
    /** @var integer */
    public $NumberOfCraft;
    /** @var integer */
    public $Status1;
    /** @var integer */
    public $Warhead;
    /** @var integer */
    public $Beam;
    /** @var integer */
    public $IFF;
    /** @var integer */
    public $Team;
    /** @var integer */
    public $GroupAI;
    /** @var integer */
    public $Markings;
    /** @var integer */
    public $Radio;
    /** @var integer */
    public $Formation;
    /** @var integer */
    public $FormationSpacing;
    /** @var integer */
    public $GlobalGroup;
    /** @var integer */
    public $LeaderSpacing;
    /** @var integer */
    public $NumberOfWaves;
    /** @var integer */
    public $Unknown1;
    /** @var boolean */
    public $Unknown2;
    /** @var integer */
    public $PlayerNumber;
    /** @var integer */
    public $ArriveOnlyIfHuman;
    /** @var integer */
    public $PlayerCraft;
    /** @var integer */
    public $Yaw;
    /** @var integer */
    public $Pitch;
    /** @var integer */
    public $Roll;
    /** @var integer */
    public $ArrivalDifficulty;
    /** @var Trigger */
    public $Arrival1;
    /** @var Trigger */
    public $Arrival2;
    /** @var boolean */
    public $Arrival1OrArrival2;
    /** @var Trigger */
    public $Arrival3;
    /** @var Trigger */
    public $Arrival4;
    /** @var boolean */
    public $Arrival3OrArrival4;
    /** @var boolean */
    public $Arrival12OrArrival34;
    /** @var integer */
    public $Unknown3;
    /** @var integer */
    public $ArrivalDelayMinutes;
    /** @var integer */
    public $ArrivalDelaySeconds;
    /** @var Trigger */
    public $Departure1;
    /** @var Trigger */
    public $Departure2;
    /** @var boolean */
    public $Departure1OrDeparture2;
    /** @var integer */
    public $DepartureDelayMinutes;
    /** @var integer */
    public $DepartureDelaySeconds;
    /** @var integer */
    public $AbortTrigger;
    /** @var integer */
    public $Unknown4;
    /** @var integer */
    public $Unknown5;
    /** @var integer */
    public $ArrivalMothership;
    /** @var integer */
    public $ArriveViaMothership;
    /** @var integer */
    public $AlternateArrivalMothership;
    /** @var integer */
    public $AlternateArriveViaMothership;
    /** @var integer */
    public $DepartureMothership;
    /** @var integer */
    public $DepartViaMothership;
    /** @var integer */
    public $AlternateDepartureMothership;
    /** @var integer */
    public $AlternatDepartViaMothership;
    /** @var Order[] */
    public $Orders;
    /** @var Trigger[] */
    public $SkipToOrder4;
    /** @var boolean */
    public $Skip1OrSkip2;
    /** @var GoalFG[] */
    public $Goals;
    /** @var Waypt[] */
    public $Waypoints;
    /** @var boolean */
    public $Unknown17;
    /** @var boolean */
    public $Unknown18;
    /** @var boolean */
    public $Unknown19;
    /** @var integer */
    public $Unknown20;
    /** @var integer */
    public $Unknown21;
    /** @var integer */
    public $Countermeasures;
    /** @var integer */
    public $CraftExplosionTime;
    /** @var integer */
    public $Status2;
    /** @var integer */
    public $GlobalUnit;
    /** @var boolean */
    public $Unknown22;
    /** @var boolean */
    public $Unknown23;
    /** @var boolean */
    public $Unknown24;
    /** @var boolean */
    public $Unknown25;
    /** @var boolean */
    public $Unknown26;
    /** @var boolean */
    public $Unknown27;
    /** @var boolean */
    public $Unknown28;
    /** @var boolean */
    public $Unknown29;
    /** @var integer[] */
    public $OptionalWarheads;
    /** @var integer[] */
    public $OptionalBeams;
    /** @var integer[] */
    public $OptionalCountermeasures;
    /** @var integer */
    public $OptionalCraftCategory;
    /** @var integer[] */
    public $OptionalCraft;
    /** @var integer[] */
    public $NumberOfOptionalCraft;
    /** @var integer[] */
    public $NumberOfOptionalCraftWaves;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Name = $this->getString($hex, 0x000);
        $this->Roles = [];
        $offset = 0x014;
        for ($i = 0; $i < 4; $i++) {
            $t = new Role(substr($hex, $offset), $this->TIE);
            $this->Roles[] = $t;
            $offset += $t->getLength();
        }
        $this->Cargo = $this->getString($hex, 0x028);
        $this->SpecialCargo = $this->getString($hex, 0x03C);
        $this->SpecialCargoCraft = $this->getByte($hex, 0x050);
        $this->RandomSpecialCargo = $this->getBool($hex, 0x051);
        $this->CraftType = $this->getByte($hex, 0x052);
        $this->NumberOfCraft = $this->getByte($hex, 0x053);
        $this->Status1 = $this->getByte($hex, 0x054);
        $this->Warhead = $this->getByte($hex, 0x055);
        $this->Beam = $this->getByte($hex, 0x056);
        $this->IFF = $this->getByte($hex, 0x057);
        $this->Team = $this->getByte($hex, 0x058);
        $this->GroupAI = $this->getByte($hex, 0x059);
        $this->Markings = $this->getByte($hex, 0x05A);
        $this->Radio = $this->getByte($hex, 0x05B);
        $this->Formation = $this->getByte($hex, 0x05D);
        $this->FormationSpacing = $this->getByte($hex, 0x05E);
        $this->GlobalGroup = $this->getByte($hex, 0x05F);
        $this->LeaderSpacing = $this->getByte($hex, 0x060);
        $this->NumberOfWaves = $this->getByte($hex, 0x061);
        $this->Unknown1 = $this->getByte($hex, 0x062);
        $this->Unknown2 = $this->getBool($hex, 0x063);
        $this->PlayerNumber = $this->getByte($hex, 0x064);
        $this->ArriveOnlyIfHuman = $this->getByte($hex, 0x065);
        $this->PlayerCraft = $this->getByte($hex, 0x066);
        $this->Yaw = $this->getByte($hex, 0x067);
        $this->Pitch = $this->getByte($hex, 0x068);
        $this->Roll = $this->getByte($hex, 0x069);
        $this->ArrivalDifficulty = $this->getByte($hex, 0x06D);
        $this->Arrival1 = new Trigger(substr($hex, 0x06E), $this->TIE);
        $this->Arrival2 = new Trigger(substr($hex, 0x072), $this->TIE);
        $this->Arrival1OrArrival2 = $this->getBool($hex, 0x078);
        $this->Arrival3 = new Trigger(substr($hex, 0x079), $this->TIE);
        $this->Arrival4 = new Trigger(substr($hex, 0x07D), $this->TIE);
        $this->Arrival3OrArrival4 = $this->getBool($hex, 0x083);
        $this->Arrival12OrArrival34 = $this->getBool($hex, 0x084);
        $this->Unknown3 = $this->getByte($hex, 0x085);
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x086);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x087);
        $this->Departure1 = new Trigger(substr($hex, 0x088), $this->TIE);
        $this->Departure2 = new Trigger(substr($hex, 0x08C), $this->TIE);
        $this->Departure1OrDeparture2 = $this->getBool($hex, 0x092);
        $this->DepartureDelayMinutes = $this->getByte($hex, 0x093);
        $this->DepartureDelaySeconds = $this->getByte($hex, 0x094);
        $this->AbortTrigger = $this->getByte($hex, 0x095);
        $this->Unknown4 = $this->getByte($hex, 0x096);
        $this->Unknown5 = $this->getByte($hex, 0x098);
        $this->ArrivalMothership = $this->getByte($hex, 0x09A);
        $this->ArriveViaMothership = $this->getByte($hex, 0x09B);
        $this->AlternateArrivalMothership = $this->getByte($hex, 0x09C);
        $this->AlternateArriveViaMothership = $this->getByte($hex, 0x09D);
        $this->DepartureMothership = $this->getByte($hex, 0x09E);
        $this->DepartViaMothership = $this->getByte($hex, 0x09F);
        $this->AlternateDepartureMothership = $this->getByte($hex, 0x0A0);
        $this->AlternatDepartViaMothership = $this->getByte($hex, 0x0A1);
        $this->Orders = [];
        $offset = 0x0A2;
        for ($i = 0; $i < 4; $i++) {
            $t = new Order(substr($hex, $offset), $this->TIE);
            $this->Orders[] = $t;
            $offset += $t->getLength();
        }
        $this->SkipToOrder4 = [];
        $offset = 0x1EA;
        for ($i = 0; $i < 2; $i++) {
            $t = new Trigger(substr($hex, $offset), $this->TIE);
            $this->SkipToOrder4[] = $t;
            $offset += $t->getLength();
        }
        $this->Skip1OrSkip2 = $this->getBool($hex, 0x1F4);
        $this->Goals = [];
        $offset = 0x1F5;
        for ($i = 0; $i < 8; $i++) {
            $t = new GoalFG(substr($hex, $offset), $this->TIE);
            $this->Goals[] = $t;
            $offset += $t->getLength();
        }
        $this->Waypoints = [];
        $offset = 0x466;
        for ($i = 0; $i < 4; $i++) {
            $t = new Waypt(substr($hex, $offset), $this->TIE);
            $this->Waypoints[] = $t;
            $offset += $t->getLength();
        }
        $this->Unknown17 = $this->getBool($hex, 0x516);
        $this->Unknown18 = $this->getBool($hex, 0x518);
        $this->Unknown19 = $this->getBool($hex, 0x520);
        $this->Unknown20 = $this->getByte($hex, 0x521);
        $this->Unknown21 = $this->getByte($hex, 0x522);
        $this->Countermeasures = $this->getByte($hex, 0x523);
        $this->CraftExplosionTime = $this->getByte($hex, 0x524);
        $this->Status2 = $this->getByte($hex, 0x525);
        $this->GlobalUnit = $this->getByte($hex, 0x526);
        $this->Unknown22 = $this->getBool($hex, 0x527);
        $this->Unknown23 = $this->getBool($hex, 0x528);
        $this->Unknown24 = $this->getBool($hex, 0x529);
        $this->Unknown25 = $this->getBool($hex, 0x52A);
        $this->Unknown26 = $this->getBool($hex, 0x52B);
        $this->Unknown27 = $this->getBool($hex, 0x52C);
        $this->Unknown28 = $this->getBool($hex, 0x52D);
        $this->Unknown29 = $this->getBool($hex, 0x52E);
        $this->OptionalWarheads = [];
        $offset = 0x530;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalWarheads[] = $t;
            $offset += 1;
        }
        $this->OptionalBeams = [];
        $offset = 0x538;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalBeams[] = $t;
            $offset += 1;
        }
        $this->OptionalCountermeasures = [];
        $offset = 0x53E;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalCountermeasures[] = $t;
            $offset += 1;
        }
        $this->OptionalCraftCategory = $this->getByte($hex, 0x542);
        $this->OptionalCraft = [];
        $offset = 0x543;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->OptionalCraft[] = $t;
            $offset += 1;
        }
        $this->NumberOfOptionalCraft = [];
        $offset = 0x54D;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->NumberOfOptionalCraft[] = $t;
            $offset += 1;
        }
        $this->NumberOfOptionalCraftWaves = [];
        $offset = 0x557;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->getByte($hex, $offset);
            $this->NumberOfOptionalCraftWaves[] = $t;
            $offset += 1;
        }
        
    }
    
    public function __debugInfo()
    {
        return [
            "Name" => $this->Name,
            "Roles" => $this->Roles,
            "Cargo" => $this->Cargo,
            "SpecialCargo" => $this->SpecialCargo,
            "SpecialCargoCraft" => $this->SpecialCargoCraft,
            "RandomSpecialCargo" => $this->RandomSpecialCargo,
            "CraftType" => $this->getCraftTypeLabel(),
            "NumberOfCraft" => $this->NumberOfCraft,
            "Status1" => $this->getStatus1Label(),
            "Warhead" => $this->getWarheadLabel(),
            "Beam" => $this->getBeamLabel(),
            "IFF" => $this->IFF,
            "Team" => $this->Team,
            "GroupAI" => $this->getGroupAILabel(),
            "Markings" => $this->getMarkingsLabel(),
            "Radio" => $this->getRadioLabel(),
            "Formation" => $this->getFormationLabel(),
            "FormationSpacing" => $this->FormationSpacing,
            "GlobalGroup" => $this->GlobalGroup,
            "LeaderSpacing" => $this->LeaderSpacing,
            "NumberOfWaves" => $this->NumberOfWaves,
            "Unknown1" => $this->Unknown1,
            "Unknown2" => $this->Unknown2,
            "PlayerNumber" => $this->PlayerNumber,
            "ArriveOnlyIfHuman" => $this->ArriveOnlyIfHuman,
            "PlayerCraft" => $this->PlayerCraft,
            "Yaw" => $this->Yaw,
            "Pitch" => $this->Pitch,
            "Roll" => $this->Roll,
            "ArrivalDifficulty" => $this->getArrivalDifficultyLabel(),
            "Arrival1" => $this->Arrival1,
            "Arrival2" => $this->Arrival2,
            "Arrival1OrArrival2" => $this->Arrival1OrArrival2,
            "Arrival3" => $this->Arrival3,
            "Arrival4" => $this->Arrival4,
            "Arrival3OrArrival4" => $this->Arrival3OrArrival4,
            "Arrival12OrArrival34" => $this->Arrival12OrArrival34,
            "Unknown3" => $this->Unknown3,
            "ArrivalDelayMinutes" => $this->ArrivalDelayMinutes,
            "ArrivalDelaySeconds" => $this->ArrivalDelaySeconds,
            "Departure1" => $this->Departure1,
            "Departure2" => $this->Departure2,
            "Departure1OrDeparture2" => $this->Departure1OrDeparture2,
            "DepartureDelayMinutes" => $this->DepartureDelayMinutes,
            "DepartureDelaySeconds" => $this->DepartureDelaySeconds,
            "AbortTrigger" => $this->getAbortTriggerLabel(),
            "Unknown4" => $this->Unknown4,
            "Unknown5" => $this->Unknown5,
            "ArrivalMothership" => $this->ArrivalMothership,
            "ArriveViaMothership" => $this->ArriveViaMothership,
            "AlternateArrivalMothership" => $this->AlternateArrivalMothership,
            "AlternateArriveViaMothership" => $this->AlternateArriveViaMothership,
            "DepartureMothership" => $this->DepartureMothership,
            "DepartViaMothership" => $this->DepartViaMothership,
            "AlternateDepartureMothership" => $this->AlternateDepartureMothership,
            "AlternatDepartViaMothership" => $this->AlternatDepartViaMothership,
            "Orders" => $this->Orders,
            "SkipToOrder4" => $this->SkipToOrder4,
            "Skip1OrSkip2" => $this->Skip1OrSkip2,
            "Goals" => $this->Goals,
            "Waypoints" => $this->Waypoints,
            "Unknown17" => $this->Unknown17,
            "Unknown18" => $this->Unknown18,
            "Unknown19" => $this->Unknown19,
            "Unknown20" => $this->Unknown20,
            "Unknown21" => $this->Unknown21,
            "Countermeasures" => $this->Countermeasures,
            "CraftExplosionTime" => $this->CraftExplosionTime,
            "Status2" => $this->getStatus2Label(),
            "GlobalUnit" => $this->GlobalUnit,
            "Unknown22" => $this->Unknown22,
            "Unknown23" => $this->Unknown23,
            "Unknown24" => $this->Unknown24,
            "Unknown25" => $this->Unknown25,
            "Unknown26" => $this->Unknown26,
            "Unknown27" => $this->Unknown27,
            "Unknown28" => $this->Unknown28,
            "Unknown29" => $this->Unknown29,
            "OptionalWarheads" => $this->OptionalWarheads,
            "OptionalBeams" => $this->OptionalBeams,
            "OptionalCountermeasures" => $this->OptionalCountermeasures,
            "OptionalCraftCategory" => $this->OptionalCraftCategory,
            "OptionalCraft" => $this->OptionalCraft,
            "NumberOfOptionalCraft" => $this->NumberOfOptionalCraft,
            "NumberOfOptionalCraftWaves" => $this->NumberOfOptionalCraftWaves
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeString($hex, $this->Name, 0x000);
        $offset = 0x014;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Roles[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeString($hex, $this->Cargo, 0x028);
        $this->writeString($hex, $this->SpecialCargo, 0x03C);
        $this->writeByte($hex, $this->SpecialCargoCraft, 0x050);
        $this->writeBool($hex, $this->RandomSpecialCargo, 0x051);
        $this->writeByte($hex, $this->CraftType, 0x052);
        $this->writeByte($hex, $this->NumberOfCraft, 0x053);
        $this->writeByte($hex, $this->Status1, 0x054);
        $this->writeByte($hex, $this->Warhead, 0x055);
        $this->writeByte($hex, $this->Beam, 0x056);
        $this->writeByte($hex, $this->IFF, 0x057);
        $this->writeByte($hex, $this->Team, 0x058);
        $this->writeByte($hex, $this->GroupAI, 0x059);
        $this->writeByte($hex, $this->Markings, 0x05A);
        $this->writeByte($hex, $this->Radio, 0x05B);
        $this->writeByte($hex, $this->Formation, 0x05D);
        $this->writeByte($hex, $this->FormationSpacing, 0x05E);
        $this->writeByte($hex, $this->GlobalGroup, 0x05F);
        $this->writeByte($hex, $this->LeaderSpacing, 0x060);
        $this->writeByte($hex, $this->NumberOfWaves, 0x061);
        $this->writeByte($hex, $this->Unknown1, 0x062);
        $this->writeBool($hex, $this->Unknown2, 0x063);
        $this->writeByte($hex, $this->PlayerNumber, 0x064);
        $this->writeByte($hex, $this->ArriveOnlyIfHuman, 0x065);
        $this->writeByte($hex, $this->PlayerCraft, 0x066);
        $this->writeByte($hex, $this->Yaw, 0x067);
        $this->writeByte($hex, $this->Pitch, 0x068);
        $this->writeByte($hex, $this->Roll, 0x069);
        $this->writeByte($hex, $this->ArrivalDifficulty, 0x06D);
        $this->writeObject($hex, $this->Arrival1, 0x06E);
        $this->writeObject($hex, $this->Arrival2, 0x072);
        $this->writeBool($hex, $this->Arrival1OrArrival2, 0x078);
        $this->writeObject($hex, $this->Arrival3, 0x079);
        $this->writeObject($hex, $this->Arrival4, 0x07D);
        $this->writeBool($hex, $this->Arrival3OrArrival4, 0x083);
        $this->writeBool($hex, $this->Arrival12OrArrival34, 0x084);
        $this->writeByte($hex, $this->Unknown3, 0x085);
        $this->writeByte($hex, $this->ArrivalDelayMinutes, 0x086);
        $this->writeByte($hex, $this->ArrivalDelaySeconds, 0x087);
        $this->writeObject($hex, $this->Departure1, 0x088);
        $this->writeObject($hex, $this->Departure2, 0x08C);
        $this->writeBool($hex, $this->Departure1OrDeparture2, 0x092);
        $this->writeByte($hex, $this->DepartureDelayMinutes, 0x093);
        $this->writeByte($hex, $this->DepartureDelaySeconds, 0x094);
        $this->writeByte($hex, $this->AbortTrigger, 0x095);
        $this->writeByte($hex, $this->Unknown4, 0x096);
        $this->writeByte($hex, $this->Unknown5, 0x098);
        $this->writeByte($hex, $this->ArrivalMothership, 0x09A);
        $this->writeByte($hex, $this->ArriveViaMothership, 0x09B);
        $this->writeByte($hex, $this->AlternateArrivalMothership, 0x09C);
        $this->writeByte($hex, $this->AlternateArriveViaMothership, 0x09D);
        $this->writeByte($hex, $this->DepartureMothership, 0x09E);
        $this->writeByte($hex, $this->DepartViaMothership, 0x09F);
        $this->writeByte($hex, $this->AlternateDepartureMothership, 0x0A0);
        $this->writeByte($hex, $this->AlternatDepartViaMothership, 0x0A1);
        $offset = 0x0A2;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Orders[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x1EA;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->SkipToOrder4[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Skip1OrSkip2, 0x1F4);
        $offset = 0x1F5;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Goals[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x466;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Waypoints[$i];
            $this->writeObject($hex, $t, $offset);
            $offset += $t->getLength();
        }
        $this->writeBool($hex, $this->Unknown17, 0x516);
        $this->writeBool($hex, $this->Unknown18, 0x518);
        $this->writeBool($hex, $this->Unknown19, 0x520);
        $this->writeByte($hex, $this->Unknown20, 0x521);
        $this->writeByte($hex, $this->Unknown21, 0x522);
        $this->writeByte($hex, $this->Countermeasures, 0x523);
        $this->writeByte($hex, $this->CraftExplosionTime, 0x524);
        $this->writeByte($hex, $this->Status2, 0x525);
        $this->writeByte($hex, $this->GlobalUnit, 0x526);
        $this->writeBool($hex, $this->Unknown22, 0x527);
        $this->writeBool($hex, $this->Unknown23, 0x528);
        $this->writeBool($hex, $this->Unknown24, 0x529);
        $this->writeBool($hex, $this->Unknown25, 0x52A);
        $this->writeBool($hex, $this->Unknown26, 0x52B);
        $this->writeBool($hex, $this->Unknown27, 0x52C);
        $this->writeBool($hex, $this->Unknown28, 0x52D);
        $this->writeBool($hex, $this->Unknown29, 0x52E);
        $offset = 0x530;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->OptionalWarheads[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x538;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->OptionalBeams[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x53E;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->OptionalCountermeasures[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $this->writeByte($hex, $this->OptionalCraftCategory, 0x542);
        $offset = 0x543;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->OptionalCraft[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x54D;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberOfOptionalCraft[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }
        $offset = 0x557;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberOfOptionalCraftWaves[$i];
            $this->writeByte($hex, $t, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    public function getCraftTypeLabel() {
        return isset($this->CraftType) && isset(Constants::$SHIPS[$this->CraftType]) ? Constants::$SHIPS[$this->CraftType] : "Unknown";
    }

    public function getStatus1Label() {
        return isset($this->Status1) && isset(Constants::$STATUS[$this->Status1]) ? Constants::$STATUS[$this->Status1] : "Unknown";
    }

    public function getWarheadLabel() {
        return isset($this->Warhead) && isset(Constants::$WARHEAD[$this->Warhead]) ? Constants::$WARHEAD[$this->Warhead] : "Unknown";
    }

    public function getBeamLabel() {
        return isset($this->Beam) && isset(Constants::$BEAM[$this->Beam]) ? Constants::$BEAM[$this->Beam] : "Unknown";
    }

    public function getGroupAILabel() {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    public function getMarkingsLabel() {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    public function getRadioLabel() {
        return isset($this->Radio) && isset(Constants::$RADIO[$this->Radio]) ? Constants::$RADIO[$this->Radio] : "Unknown";
    }

    public function getFormationLabel() {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getArrivalDifficultyLabel() {
        return isset($this->ArrivalDifficulty) && isset(Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty]) ? Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty] : "Unknown";
    }

    public function getAbortTriggerLabel() {
        return isset($this->AbortTrigger) && isset(Constants::$ABORTTRIGGER[$this->AbortTrigger]) ? Constants::$ABORTTRIGGER[$this->AbortTrigger] : "Unknown";
    }

    public function getStatus2Label() {
        return isset($this->Status2) && isset(Constants::$STATUS[$this->Status2]) ? Constants::$STATUS[$this->Status2] : "Unknown";
    }
    
    public function getLength()
    {
        return self::FLIGHTGROUPLENGTH;
    }
}
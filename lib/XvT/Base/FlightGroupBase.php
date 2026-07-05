<?php

namespace Pyrite\XvT\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;
use Pyrite\XvT\Constants;
use Pyrite\XvT\GoalFG;
use Pyrite\XvT\Order;
use Pyrite\XvT\Role;
use Pyrite\XvT\Trigger;
use Pyrite\XvT\Waypt;

abstract class FlightGroupBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int FLIGHTGROUPLENGTH INT */
	public const FLIGHTGROUPLENGTH = 1378;
    /** @var string 0x000 Name STR */
	public string $Name;
    /** @var array<Role> 0x014 Roles Role */
	public array $Roles;
    /** @var string 0x028 Cargo STR */
	public string $Cargo;
    /** @var string 0x03C SpecialCargo STR */
	public string $SpecialCargo;
    /** @var int 0x050 SpecialCargoCraft BYTE */
	public int $SpecialCargoCraft;
    /** @var bool 0x051 RandomSpecialCargo BOOL */
	public bool $RandomSpecialCargo;
    /** @var int 0x052 CraftType BYTE */
	public int $CraftType;
    /** @var int 0x053 NumberOfCraft BYTE */
	public int $NumberOfCraft;
    /** @var int 0x054 Status1 BYTE */
	public int $Status1;
    /** @var int 0x055 Warhead BYTE */
	public int $Warhead;
    /** @var int 0x056 Beam BYTE */
	public int $Beam;
    /** @var int 0x057 IFF BYTE */
	public int $IFF;
    /** @var int 0x058 Team BYTE */
	public int $Team;
    /** @var int 0x059 GroupAI BYTE */
	public int $GroupAI;
    /** @var int 0x05A Markings BYTE */
	public int $Markings;
    /** @var int 0x05B Radio BYTE */
	public int $Radio;
    /** @var int 0x05D Formation BYTE */
	public int $Formation;
    /** @var int 0x05E FormationSpacing BYTE */
	public int $FormationSpacing;
    /** @var int 0x05F GlobalGroup BYTE */
	public int $GlobalGroup;
    /** @var int 0x060 LeaderSpacing BYTE */
	public int $LeaderSpacing;
    /** @var int 0x061 NumberOfWaves BYTE */
	public int $NumberOfWaves;
    /** @var int 0x062 Unknown1 BYTE */
	public int $Unknown1;
    /** @var bool 0x063 Unknown2 BOOL */
	public bool $Unknown2;
    /** @var int 0x064 PlayerNumber BYTE */
	public int $PlayerNumber;
    /** @var int 0x065 ArriveOnlyIfHuman BYTE */
	public int $ArriveOnlyIfHuman;
    /** @var int 0x066 PlayerCraft BYTE */
	public int $PlayerCraft;
    /** @var int 0x067 Yaw BYTE */
	public int $Yaw;
    /** @var int 0x068 Pitch BYTE */
	public int $Pitch;
    /** @var int 0x069 Roll BYTE */
	public int $Roll;
    /** @var int 0x06D ArrivalDifficulty BYTE */
	public int $ArrivalDifficulty;
    /** @var Trigger 0x06E Arrival1 Trigger */
	public Trigger $Arrival1;
    /** @var Trigger 0x072 Arrival2 Trigger */
	public Trigger $Arrival2;
    /** @var bool 0x078 Arrival1OrArrival2 BOOL */
	public bool $Arrival1OrArrival2;
    /** @var Trigger 0x079 Arrival3 Trigger */
	public Trigger $Arrival3;
    /** @var Trigger 0x07D Arrival4 Trigger */
	public Trigger $Arrival4;
    /** @var bool 0x083 Arrival3OrArrival4 BOOL */
	public bool $Arrival3OrArrival4;
    /** @var bool 0x084 Arrival12OrArrival34 BOOL */
	public bool $Arrival12OrArrival34;
    /** @var int 0x085 Unknown3 BYTE */
	public int $Unknown3;
    /** @var int 0x086 ArrivalDelayMinutes BYTE */
	public int $ArrivalDelayMinutes;
    /** @var int 0x087 ArrivalDelaySeconds BYTE */
	public int $ArrivalDelaySeconds;
    /** @var Trigger 0x088 Departure1 Trigger */
	public Trigger $Departure1;
    /** @var Trigger 0x08C Departure2 Trigger */
	public Trigger $Departure2;
    /** @var bool 0x092 Departure1OrDeparture2 BOOL */
	public bool $Departure1OrDeparture2;
    /** @var int 0x093 DepartureDelayMinutes BYTE */
	public int $DepartureDelayMinutes;
    /** @var int 0x094 DepartureDelaySeconds BYTE */
	public int $DepartureDelaySeconds;
    /** @var int 0x095 AbortTrigger BYTE */
	public int $AbortTrigger;
    /** @var int 0x096 Unknown4 BYTE */
	public int $Unknown4;
    /** @var int 0x098 Unknown5 BYTE */
	public int $Unknown5;
    /** @var int 0x09A ArrivalMothership BYTE */
	public int $ArrivalMothership;
    /** @var int 0x09B ArriveViaMothership BYTE */
	public int $ArriveViaMothership;
    /** @var int 0x09C AlternateArrivalMothership BYTE */
	public int $AlternateArrivalMothership;
    /** @var int 0x09D AlternateArriveViaMothership BYTE */
	public int $AlternateArriveViaMothership;
    /** @var int 0x09E DepartureMothership BYTE */
	public int $DepartureMothership;
    /** @var int 0x09F DepartViaMothership BYTE */
	public int $DepartViaMothership;
    /** @var int 0x0A0 AlternateDepartureMothership BYTE */
	public int $AlternateDepartureMothership;
    /** @var int 0x0A1 AlternatDepartViaMothership BYTE */
	public int $AlternatDepartViaMothership;
    /** @var array<Order> 0x0A2 Orders Order */
	public array $Orders;
    /** @var array<Trigger> 0x1EA SkipToOrder4 Trigger */
	public array $SkipToOrder4;
    /** @var bool 0x1F4 Skip1OrSkip2 BOOL */
	public bool $Skip1OrSkip2;
    /** @var array<GoalFG> 0x1F5 Goals GoalFG */
	public array $Goals;
    /** @var array<Waypt> 0x466 Waypoints Waypt */
	public array $Waypoints;
    /** @var bool 0x516 Unknown17 BOOL */
	public bool $Unknown17;
    /** @var bool 0x518 Unknown18 BOOL */
	public bool $Unknown18;
    /** @var bool 0x520 Unknown19 BOOL */
	public bool $Unknown19;
    /** @var int 0x521 Unknown20 BYTE */
	public int $Unknown20;
    /** @var int 0x522 Unknown21 BYTE */
	public int $Unknown21;
    /** @var int 0x523 Countermeasures BYTE */
	public int $Countermeasures;
    /** @var int 0x524 CraftExplosionTime BYTE */
	public int $CraftExplosionTime;
    /** @var int 0x525 Status2 BYTE */
	public int $Status2;
    /** @var int 0x526 GlobalUnit BYTE */
	public int $GlobalUnit;
    /** @var bool 0x527 Unknown22 BOOL */
	public bool $Unknown22;
    /** @var bool 0x528 Unknown23 BOOL */
	public bool $Unknown23;
    /** @var bool 0x529 Unknown24 BOOL */
	public bool $Unknown24;
    /** @var bool 0x52A Unknown25 BOOL */
	public bool $Unknown25;
    /** @var bool 0x52B Unknown26 BOOL */
	public bool $Unknown26;
    /** @var bool 0x52C Unknown27 BOOL */
	public bool $Unknown27;
    /** @var bool 0x52D Unknown28 BOOL */
	public bool $Unknown28;
    /** @var bool 0x52E Unknown29 BOOL */
	public bool $Unknown29;
    /** @var array<int> 0x530 OptionalWarheads BYTE */
	public array $OptionalWarheads;
    /** @var array<int> 0x538 OptionalBeams BYTE */
	public array $OptionalBeams;
    /** @var array<int> 0x53E OptionalCountermeasures BYTE */
	public array $OptionalCountermeasures;
    /** @var int 0x542 OptionalCraftCategory BYTE */
	public int $OptionalCraftCategory;
    /** @var array<int> 0x543 OptionalCraft BYTE */
	public array $OptionalCraft;
    /** @var array<int> 0x54D NumberOfOptionalCraft BYTE */
	public array $NumberOfOptionalCraft;
    /** @var array<int> 0x557 NumberOfOptionalCraftWaves BYTE */
	public array $NumberOfOptionalCraftWaves;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
    {
        $hex = $this->hex;
        $offset = 0;

        $this->Name = $this->getString($hex, 0x000);
        $this->Roles = [];
        $offset = 0x014;
        for ($i = 0; $i < 4; $i++) {
            $t = (new Role(substr($hex, $offset), $this->TIE))->loadHex();
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
        $this->Arrival1 = (new Trigger(substr($hex, 0x06E), $this->TIE))->loadHex();
        $this->Arrival2 = (new Trigger(substr($hex, 0x072), $this->TIE))->loadHex();
        $this->Arrival1OrArrival2 = $this->getBool($hex, 0x078);
        $this->Arrival3 = (new Trigger(substr($hex, 0x079), $this->TIE))->loadHex();
        $this->Arrival4 = (new Trigger(substr($hex, 0x07D), $this->TIE))->loadHex();
        $this->Arrival3OrArrival4 = $this->getBool($hex, 0x083);
        $this->Arrival12OrArrival34 = $this->getBool($hex, 0x084);
        $this->Unknown3 = $this->getByte($hex, 0x085);
        $this->ArrivalDelayMinutes = $this->getByte($hex, 0x086);
        $this->ArrivalDelaySeconds = $this->getByte($hex, 0x087);
        $this->Departure1 = (new Trigger(substr($hex, 0x088), $this->TIE))->loadHex();
        $this->Departure2 = (new Trigger(substr($hex, 0x08C), $this->TIE))->loadHex();
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
            $t = (new Order(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Orders[] = $t;
            $offset += $t->getLength();
        }
        $this->SkipToOrder4 = [];
        $offset = 0x1EA;
        for ($i = 0; $i < 2; $i++) {
            $t = (new Trigger(substr($hex, $offset), $this->TIE))->loadHex();
            $this->SkipToOrder4[] = $t;
            $offset += $t->getLength();
        }
        $this->Skip1OrSkip2 = $this->getBool($hex, 0x1F4);
        $this->Goals = [];
        $offset = 0x1F5;
        for ($i = 0; $i < 8; $i++) {
            $t = (new GoalFG(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Goals[] = $t;
            $offset += $t->getLength();
        }
        $this->Waypoints = [];
        $offset = 0x466;
        for ($i = 0; $i < 4; $i++) {
            $t = (new Waypt(substr($hex, $offset), $this->TIE))->loadHex();
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
        

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
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
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeString($this->Name, $hex, 0x000);
        $offset = 0x014;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Roles[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeString($this->Cargo, $hex, 0x028);
        $hex = $this->writeString($this->SpecialCargo, $hex, 0x03C);
        $hex = $this->writeByte($this->SpecialCargoCraft, $hex, 0x050);
        $hex = $this->writeBool($this->RandomSpecialCargo, $hex, 0x051);
        $hex = $this->writeByte($this->CraftType, $hex, 0x052);
        $hex = $this->writeByte($this->NumberOfCraft, $hex, 0x053);
        $hex = $this->writeByte($this->Status1, $hex, 0x054);
        $hex = $this->writeByte($this->Warhead, $hex, 0x055);
        $hex = $this->writeByte($this->Beam, $hex, 0x056);
        $hex = $this->writeByte($this->IFF, $hex, 0x057);
        $hex = $this->writeByte($this->Team, $hex, 0x058);
        $hex = $this->writeByte($this->GroupAI, $hex, 0x059);
        $hex = $this->writeByte($this->Markings, $hex, 0x05A);
        $hex = $this->writeByte($this->Radio, $hex, 0x05B);
        $hex = $this->writeByte($this->Formation, $hex, 0x05D);
        $hex = $this->writeByte($this->FormationSpacing, $hex, 0x05E);
        $hex = $this->writeByte($this->GlobalGroup, $hex, 0x05F);
        $hex = $this->writeByte($this->LeaderSpacing, $hex, 0x060);
        $hex = $this->writeByte($this->NumberOfWaves, $hex, 0x061);
        $hex = $this->writeByte($this->Unknown1, $hex, 0x062);
        $hex = $this->writeBool($this->Unknown2, $hex, 0x063);
        $hex = $this->writeByte($this->PlayerNumber, $hex, 0x064);
        $hex = $this->writeByte($this->ArriveOnlyIfHuman, $hex, 0x065);
        $hex = $this->writeByte($this->PlayerCraft, $hex, 0x066);
        $hex = $this->writeByte($this->Yaw, $hex, 0x067);
        $hex = $this->writeByte($this->Pitch, $hex, 0x068);
        $hex = $this->writeByte($this->Roll, $hex, 0x069);
        $hex = $this->writeByte($this->ArrivalDifficulty, $hex, 0x06D);
        $hex = $this->writeObject($this->Arrival1, $hex, 0x06E);
        $hex = $this->writeObject($this->Arrival2, $hex, 0x072);
        $hex = $this->writeBool($this->Arrival1OrArrival2, $hex, 0x078);
        $hex = $this->writeObject($this->Arrival3, $hex, 0x079);
        $hex = $this->writeObject($this->Arrival4, $hex, 0x07D);
        $hex = $this->writeBool($this->Arrival3OrArrival4, $hex, 0x083);
        $hex = $this->writeBool($this->Arrival12OrArrival34, $hex, 0x084);
        $hex = $this->writeByte($this->Unknown3, $hex, 0x085);
        $hex = $this->writeByte($this->ArrivalDelayMinutes, $hex, 0x086);
        $hex = $this->writeByte($this->ArrivalDelaySeconds, $hex, 0x087);
        $hex = $this->writeObject($this->Departure1, $hex, 0x088);
        $hex = $this->writeObject($this->Departure2, $hex, 0x08C);
        $hex = $this->writeBool($this->Departure1OrDeparture2, $hex, 0x092);
        $hex = $this->writeByte($this->DepartureDelayMinutes, $hex, 0x093);
        $hex = $this->writeByte($this->DepartureDelaySeconds, $hex, 0x094);
        $hex = $this->writeByte($this->AbortTrigger, $hex, 0x095);
        $hex = $this->writeByte($this->Unknown4, $hex, 0x096);
        $hex = $this->writeByte($this->Unknown5, $hex, 0x098);
        $hex = $this->writeByte($this->ArrivalMothership, $hex, 0x09A);
        $hex = $this->writeByte($this->ArriveViaMothership, $hex, 0x09B);
        $hex = $this->writeByte($this->AlternateArrivalMothership, $hex, 0x09C);
        $hex = $this->writeByte($this->AlternateArriveViaMothership, $hex, 0x09D);
        $hex = $this->writeByte($this->DepartureMothership, $hex, 0x09E);
        $hex = $this->writeByte($this->DepartViaMothership, $hex, 0x09F);
        $hex = $this->writeByte($this->AlternateDepartureMothership, $hex, 0x0A0);
        $hex = $this->writeByte($this->AlternatDepartViaMothership, $hex, 0x0A1);
        $offset = 0x0A2;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Orders[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x1EA;
        for ($i = 0; $i < 2; $i++) {
            $t = $this->SkipToOrder4[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Skip1OrSkip2, $hex, 0x1F4);
        $offset = 0x1F5;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->Goals[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $offset = 0x466;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->Waypoints[$i];
            $hex = $this->writeObject($t, $hex, $offset);
            $offset += $t->getLength();
        }
        $hex = $this->writeBool($this->Unknown17, $hex, 0x516);
        $hex = $this->writeBool($this->Unknown18, $hex, 0x518);
        $hex = $this->writeBool($this->Unknown19, $hex, 0x520);
        $hex = $this->writeByte($this->Unknown20, $hex, 0x521);
        $hex = $this->writeByte($this->Unknown21, $hex, 0x522);
        $hex = $this->writeByte($this->Countermeasures, $hex, 0x523);
        $hex = $this->writeByte($this->CraftExplosionTime, $hex, 0x524);
        $hex = $this->writeByte($this->Status2, $hex, 0x525);
        $hex = $this->writeByte($this->GlobalUnit, $hex, 0x526);
        $hex = $this->writeBool($this->Unknown22, $hex, 0x527);
        $hex = $this->writeBool($this->Unknown23, $hex, 0x528);
        $hex = $this->writeBool($this->Unknown24, $hex, 0x529);
        $hex = $this->writeBool($this->Unknown25, $hex, 0x52A);
        $hex = $this->writeBool($this->Unknown26, $hex, 0x52B);
        $hex = $this->writeBool($this->Unknown27, $hex, 0x52C);
        $hex = $this->writeBool($this->Unknown28, $hex, 0x52D);
        $hex = $this->writeBool($this->Unknown29, $hex, 0x52E);
        $offset = 0x530;
        for ($i = 0; $i < 8; $i++) {
            $t = $this->OptionalWarheads[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x538;
        for ($i = 0; $i < 4; $i++) {
            $t = $this->OptionalBeams[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x53E;
        for ($i = 0; $i < 3; $i++) {
            $t = $this->OptionalCountermeasures[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $hex = $this->writeByte($this->OptionalCraftCategory, $hex, 0x542);
        $offset = 0x543;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->OptionalCraft[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x54D;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberOfOptionalCraft[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }
        $offset = 0x557;
        for ($i = 0; $i < 10; $i++) {
            $t = $this->NumberOfOptionalCraftWaves[$i];
            $hex = $this->writeByte($t, $hex, $offset);
            $offset += 1;
        }

        return $hex;
    }
    
    public function getCraftTypeLabel(): string 
    {
        return isset($this->CraftType) && isset(Constants::$SHIPS[$this->CraftType]) ? Constants::$SHIPS[$this->CraftType] : "Unknown";
    }

    public function getStatus1Label(): string 
    {
        return isset($this->Status1) && isset(Constants::$STATUS[$this->Status1]) ? Constants::$STATUS[$this->Status1] : "Unknown";
    }

    public function getWarheadLabel(): string 
    {
        return isset($this->Warhead) && isset(Constants::$WARHEAD[$this->Warhead]) ? Constants::$WARHEAD[$this->Warhead] : "Unknown";
    }

    public function getBeamLabel(): string 
    {
        return isset($this->Beam) && isset(Constants::$BEAM[$this->Beam]) ? Constants::$BEAM[$this->Beam] : "Unknown";
    }

    public function getGroupAILabel(): string 
    {
        return isset($this->GroupAI) && isset(Constants::$GROUPAI[$this->GroupAI]) ? Constants::$GROUPAI[$this->GroupAI] : "Unknown";
    }

    public function getMarkingsLabel(): string 
    {
        return isset($this->Markings) && isset(Constants::$MARKINGS[$this->Markings]) ? Constants::$MARKINGS[$this->Markings] : "Unknown";
    }

    public function getRadioLabel(): string 
    {
        return isset($this->Radio) && isset(Constants::$RADIO[$this->Radio]) ? Constants::$RADIO[$this->Radio] : "Unknown";
    }

    public function getFormationLabel(): string 
    {
        return isset($this->Formation) && isset(Constants::$FORMATION[$this->Formation]) ? Constants::$FORMATION[$this->Formation] : "Unknown";
    }

    public function getArrivalDifficultyLabel(): string 
    {
        return isset($this->ArrivalDifficulty) && isset(Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty]) ? Constants::$ARRIVALDIFFICULTY[$this->ArrivalDifficulty] : "Unknown";
    }

    public function getAbortTriggerLabel(): string 
    {
        return isset($this->AbortTrigger) && isset(Constants::$ABORTTRIGGER[$this->AbortTrigger]) ? Constants::$ABORTTRIGGER[$this->AbortTrigger] : "Unknown";
    }

    public function getStatus2Label(): string 
    {
        return isset($this->Status2) && isset(Constants::$STATUS[$this->Status2]) ? Constants::$STATUS[$this->Status2] : "Unknown";
    }
    
    public function getLength(): int
    {
        return self::FLIGHTGROUPLENGTH;
    }
}
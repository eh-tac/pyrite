<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class FlightGroup implements Byteable
{
  use HexDecoder;

  const FLIGHTGROUP_LENGTH = 0x562;

  public $Name;
  public $Roles;
  public $Cargo;
  public $SpecialCargo;
  public $SpecialCargoCraft;
  public $RandomSpecialCargo;
  public $CraftType;
  public $NumberOfCraft;
  public $Status1;
  public $Warhead;
  public $Beam;
  public $IFF;
  public $Team;
  public $GroupAI;
  public $Markings;
  public $Radio;
  public $Formation;
  public $FormationSpacing;
  public $GlobalGroup;
  public $LeaderSpacing;
  public $NumberOfWaves;
  public $Unknown1;
  public $Unknown2;
  public $PlayerNumber;
  public $ArriveOnlyIfHuman;
  public $PlayerCraft;
  public $Yaw;
  public $Pitch;
  public $Roll;
  public $ArrivalDifficulty;
  public $Arrival1;
  public $Arrival2;
  public $Arrival1OrArrival2;
  public $Arrival3;
  public $Arrival4;
  public $Arrival3OrArrival4;
  public $Arrival12OrArrival34;
  public $Unknown3;
  public $ArrivalDelayMinutes;
  public $ArrivalDelaySeconds;
  public $Departure1;
  public $Departure2;
  public $Departure1OrDeparture2;
  public $DepartureDelayMinutes;
  public $DepartureDelaySeconds;
  public $AbortTrigger;
  public $Unknown4;
  public $Unknown5;
  public $ArrivalMothership;
  public $ArriveViaMothership;
  public $AlternateArrivalMothership;
  public $AlternateArriveViaMothership;
  public $DepartureMothership;
  public $DepartViaMothership;
  public $AlternateDepartureMothership;
  public $AlternatDepartViaMothership;
  public $Orders;
  public $SkipToOrder4;
  public $Skip1OrSkip2;
  public $Goals;
  public $Waypoints;
  public $Unknown17;
  public $Unknown18;
  public $Unknown19;
  public $Unknown20;
  public $Unknown21;
  public $Countermeasures;
  public $CraftExplosionTime;
  public $Status2;
  public $GlobalUnit;
  public $Unknown22;
  public $Unknown23;
  public $Unknown24;
  public $Unknown25;
  public $Unknown26;
  public $Unknown27;
  public $Unknown28;
  public $Unknown29;
  public $OptionalWarheads;
  public $OptionalBeams;
  public $OptionalCountermeasures;
  public $OptionalCraftCategory;
  public $OptionalCraft;
  public $NumberOfOptionalCraft;
  public $NumberOfOptionalCraftWaves;
  public function __construct($hex)
  {
    $this->Name = $this->getString($hex, 0x000, 20);
    $this->Roles = array();
    for ($i = 0; $i < 4; $i++) {
      $this->Roles[] = new Role(substr($hex, 0x014 + $i));
    }

    $this->Cargo = $this->getString($hex, 0x028, 20);
    $this->SpecialCargo = $this->getString($hex, 0x03C, 20);
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
    $this->Arrival1 = new Trigger(substr($hex, 0x06E));
    $this->Arrival2 = new Trigger(substr($hex, 0x072));
    $this->Arrival1OrArrival2 = $this->getBool($hex, 0x078);
    $this->Arrival3 = new Trigger(substr($hex, 0x079));
    $this->Arrival4 = new Trigger(substr($hex, 0x07D));
    $this->Arrival3OrArrival4 = $this->getBool($hex, 0x083);
    $this->Arrival12OrArrival34 = $this->getBool($hex, 0x084);
    $this->Unknown3 = $this->getByte($hex, 0x085);
    $this->ArrivalDelayMinutes = $this->getByte($hex, 0x086);
    $this->ArrivalDelaySeconds = $this->getByte($hex, 0x087);
    $this->Departure1 = new Trigger(substr($hex, 0x088));
    $this->Departure2 = new Trigger(substr($hex, 0x08C));
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
    $this->Orders = array();
    for ($i = 0; $i < 4; $i++) {
      $this->Orders[] = new Order(substr($hex, 0x0A2 + $i));
    }

    $this->SkipToOrder4 = array();
    for ($i = 0; $i < 2; $i++) {
      $this->SkipToOrder4[] = new Trigger(substr($hex, 0x1EA + $i));
    }

    $this->Skip1OrSkip2 = $this->getBool($hex, 0x1F4);
    $this->Goals = array();
    for ($i = 0; $i < 8; $i++) {
      $this->Goals[] = new GoalFG(substr($hex, 0x1F5 + $i));
    }

    $this->Waypoints = array();
    for ($i = 0; $i < 4; $i++) {
      $this->Waypoints[] = new Waypt(substr($hex, 0x466 + $i));
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
    $this->OptionalWarheads = array();
    for ($i = 0; $i < 8; $i++) {
      $this->OptionalWarheads[] = $this->getByte($hex, 0x530 + $i);
    }

    $this->OptionalBeams = array();
    for ($i = 0; $i < 4; $i++) {
      $this->OptionalBeams[] = $this->getByte($hex, 0x538 + $i);
    }

    $this->OptionalCountermeasures = array();
    for ($i = 0; $i < 3; $i++) {
      $this->OptionalCountermeasures[] = $this->getByte($hex, 0x53E + $i);
    }

    $this->OptionalCraftCategory = $this->getByte($hex, 0x542);
    $this->OptionalCraft = array();
    for ($i = 0; $i < 10; $i++) {
      $this->OptionalCraft[] = $this->getByte($hex, 0x543 + $i);
    }

    $this->NumberOfOptionalCraft = array();
    for ($i = 0; $i < 10; $i++) {
      $this->NumberOfOptionalCraft[] = $this->getByte($hex, 0x54D + $i);
    }

    $this->NumberOfOptionalCraftWaves = array();
    for ($i = 0; $i < 10; $i++) {
      $this->NumberOfOptionalCraftWaves[] = $this->getByte($hex, 0x557 + $i);
    }
  }

  public function getLength()
  {
    return self::FLIGHTGROUP_LENGTH;
  }

  public function __toString()
  {
    return count($this) . 'x ' . $this->ShipType->Abbr . ' ' . $this->Name .
      "";
  }

  public function count()
  {
    return (int) ($this->NumberOfWaves + 1) * (int) $this->NumberOfCraft;
  }

  public function coop()
  {
    $c = (int) ($this->NumberOfWaves + 1) * (int) $this->NumberOfCraft;
    $ct = new CraftType($this->CraftType);
    return $c . 'x ' . $ct->Abbr;
  }

  public function isPlayerCraft()
  {
    return (bool) $this->PlayerNumber;
  }
}

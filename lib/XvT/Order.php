<?php

namespace Pyrite\XvT;

use Pyrite\Byteable;
use Pyrite\HexDecoder;

class Order implements Byteable
{
  use HexDecoder;

  const HEADER_LENGTH = 0x52;

  public $Order;
  public $Throttle;
  public $Variable1;
  public $Variable2;
  public $Unknown6;
  public $Unknown7;
  public $Target3Type;
  public $Target4Type;
  public $Target3;
  public $Target4;
  public $Target3OrTarget4;
  public $Unknown8;
  public $Target1Type;
  public $Target1;
  public $Target2Type;
  public $Target2;
  public $Target1OrTarget2;
  public $Unknown9;
  public $Speed;
  public $Designation;
  public function __construct($hex)
  {
    $this->Order = $this->getByte($hex, 0x00);
    $this->Throttle = $this->getByte($hex, 0x01);
    $this->Variable1 = $this->getByte($hex, 0x02);
    $this->Variable2 = $this->getByte($hex, 0x03);
    $this->Unknown6 = $this->getByte($hex, 0x04);
    $this->Unknown7 = $this->getByte($hex, 0x05);
    $this->Target3Type = $this->getByte($hex, 0x06);
    $this->Target4Type = $this->getByte($hex, 0x07);
    $this->Target3 = $this->getByte($hex, 0x08);
    $this->Target4 = $this->getByte($hex, 0x09);
    $this->Target3OrTarget4 = $this->getBool($hex, 0x0A);
    $this->Unknown8 = $this->getByte($hex, 0x0B);
    $this->Target1Type = $this->getByte($hex, 0x0C);
    $this->Target1 = $this->getByte($hex, 0x0D);
    $this->Target2Type = $this->getByte($hex, 0x0E);
    $this->Target2 = $this->getByte($hex, 0x0F);
    $this->Target1OrTarget2 = $this->getBool($hex, 0x10);
    $this->Unknown9 = $this->getByte($hex, 0x11);
    $this->Speed = $this->getByte($hex, 0x12);
    $this->Designation = $this->getString($hex, 0x13, 16);
  }

  public function getLength()
  {
    return self::HEADER_LENGTH;
  }
}

<?php

namespace Pyrite\EHBL;

final class BattleType
{
  const FREE = "F";
  const TC = "TC";
  const IW = "IW";
  const DB = "DB";
  const FCHG = "FCHG";
  const CAB = "CAB";
  const ID = "ID";
  const IS = "IS";
  const DIR = "DIR";
  const BHG = "BHG";
  const FMC = "FMC";
  const HF = "HF";
  const CD = "CD";
  const CMP = "CMP";
  const UNKNOWN = "UNK";
  const TAC = "TAC";

  public static $ALL = [self::TC, self::IW, self::DB, self::FCHG, self::CAB, self::ID, self::BHG, self::FMC, self::HF, self::CD, self::TAC, self::UNK, self::IS, self::DIR, self::CMP, self::FREE];
}

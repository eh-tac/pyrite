<?php

namespace Pyrite\EHBL;

enum BattleType: string
{
  case FREE = "F";
  case TC = "TC";
  case IW = "IW";
  case DB = "DB";
  case FCHG = "FCHG";
  case CAB = "CAB";
  case ID = "ID";
  case IS = "IS";
  case DIR = "DIR";
  case BHG = "BHG";
  case FMC = "FMC";
  case HF = "HF";
  case CD = "CD";
  case CMP = "CMP";
  case UNKNOWN = "UNK";
  case TAC = "TAC";
}

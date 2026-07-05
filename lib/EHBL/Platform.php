<?php

namespace Pyrite\EHBL;

enum Platform: string
{
	case XW = "XW";
	case TIE = "TIE";
	case XvT = "XvT";
	case BoP = "BoP";
	case XWA = "XWA";
	case TFTC = "TFTC";
	case EMB = "EMB";

	public function id(): int
	{
		return match ($this) {
			Platform::TIE => 0,
			Platform::XvT => 1,
			Platform::BoP => 2,
			Platform::XWA => 3,
			Platform::XW => 4, // not yet supported by EHBL,
			Platform::TFTC => 17,
			Platform::EMB => 25,
		};
	}
}

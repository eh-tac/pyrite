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
	case XWVM = "XWVM";
	case EMB = "EMB";

	public function id(): int
	{
		return match ($this) {
			Platform::TIE => 0,
			Platform::XvT => 1,
			Platform::BoP => 2,
			Platform::XWA => 3,
			Platform::XW => 4, // XW and other platforms are not supported in the EHBL, but we can still use the enum to identify them
			Platform::TFTC => 17,
			Platform::EMB => 24,
			Platform::XWVM => 25,
		};
	}
}

<?php

namespace Pyrite\EHBL;

final class Platform
{
	const XW = "XW";
	const TIE = "TIE";
	const XvT = "XvT";
	const BoP = "BoP";
	const XWA = "XWA";
	const TFTC = "TFTC";

	public static $ALL = [self::TIE, self::XvT, self::BoP, self::XWA, self::XW, self::TFTC];

	public static function battleIndexID($platform)
	{
		$lookup = [
			Platform::TIE => 0,
			Platform::XvT => 1,
			Platform::BoP => 2,
			Platform::XWA => 3,
			Platform::XW => 4, // not yet supported by EHBL,
			Platform::TFTC => 17
		];
		return $lookup[$platform];
	}
}

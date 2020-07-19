<?php

namespace Pyrite\EHBL;

final class Platform {
	const TIE = "TIE";
	const XvT = "XvT";
	const BoP = "BoP";
	const XWA = "XWA";

	public static $ALL = [self::TIE, self::XvT, self::BoP, self::XWA];

	public static function battleIndexID($platform) {
	    $lookup = [
	        Platform::TIE => 0,
            Platform::XvT => 1,
            Platform::BoP => 2,
            Platform::XWA => 3
        ];
	    return $lookup[$platform];
    }

}
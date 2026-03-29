<?php

namespace Pyrite\XvT;

use Pyrite\XvT\Base\PL2FileRecordBase;

// Swap between PLTFileRecord and PL2FileRecord depending on the file size.
class PilotFile
{
    public static function fromHex($hex, $tie = null): IPilotFileBSF
    {
        if (strlen($hex) === PL2FileRecordBase::PL2FILERECORDLENGTH) {
            return PL2FileRecord::fromHex($hex, $tie);
        }
        return PLTFileRecord::fromHex($hex, $tie);
    }
}

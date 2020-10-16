<?php

namespace Pyrite\TIE;

class PilotFile extends Base\PilotFileBase
{
    public $filename = "";

    public function beforeConstruct()
    {
    }

    public function __toString()
    {
        return "XW PLT: {$this->filename}";
    }

    public static function load($file)
    {
        $hex = file_get_contents($file);
        $info = pathinfo($file);
        $plt = new PilotFile($hex);
        $plt->filename = $info['filename'];

        return $plt;
    }

}

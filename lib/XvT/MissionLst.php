<?php

namespace Pyrite\XvT;

class MissionLst
{
    public $entries = [];

    public function __construct()
    {
    }

    public static function fromString($str)
    {
        $lst = new MissionLst();
        $lines = explode("\n", $str);
        for ($i = 2; $i < count($lines); $i += 3) {
            $a = $i - 2;
            $bit = array_slice($lines, $a, 3);
            $lst->addEntry($bit);
        }
        return $lst;
    }

    public function addEntry($lines)
    {
        if (trim($lines[0]) === '//') {
            $this->entries[] = [
                'type' => 'header',
                'title' => str_replace(['[', ']'], '', $lines[1])
            ];
        } else if (is_numeric(trim($lines[0]))) {
            $this->entries[] = [
                'type' => 'mission',
                'index' => (int)$lines[0],
                'filename' => $lines[1],
                'title' => $lines[2]
            ];
        }
    }

    public function missionCount()
    {
        return count(array_filter($this->entries, fn ($e) => $e['type'] === 'mission'));
    }

    public function maxIndex()
    {
        $missions = array_filter($this->entries, fn ($e) => $e['type'] === 'mission');
        $indexes = array_map(fn ($e) => $e['index'], $missions);
        if (empty($indexes)) {
            // echo "warning - bad lst?" . (string)$this;
            return -1;
        }
        return max($indexes);
    }

    public function getMissionIndexForFile($filename) {
        
        return array_reduce($this->entries, function($carry, $e) use ($filename) {
            if ($e['type'] === 'mission' && strtolower(trim($e['filename'])) === strtolower(trim($filename))) {
                return $e['index'];
            }
            return $carry;
        }, PHP_INT_MAX);
    }

    public function __toString()
    {
        $out = [];
        foreach ($this->entries as $e) {
            if ($e['type'] === 'header') {
                $out[] = '//';
                $out[] = '[' . $e['title'] . ']';
                $out[] = '//';
            } else {
                $out[] = $e['index'];
                $out[] = $e['filename'];
                $out[] = $e['title'];
            }
        }
        return implode("\n", $out);
    }
}

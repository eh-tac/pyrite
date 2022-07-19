<?php

namespace Pyrite\TIE;

class Briefing extends Base\BriefingBase
{
    public function __construct($hex)
    {
        $this->hex = $hex;
        $offset = 0;
        $this->RunningTime = $this->getShort($hex, 0x000);
        $this->Unknown = $this->getShort($hex, 0x002);
        $this->StartLength = $this->getShort($hex, 0x004);
        $this->EventsLength = $this->getInt($hex, 0x006);

        $this->Events = [];
        $offset = 0x00a;
        $eventParsed = 0;
        while ($eventParsed < $this->EventsLength * 2) {
            //        for ($i = 0; $i < $this->EventsLength; $i++) {
            $t = (new Event(substr($hex, $offset), $this->TIE))->loadHex();
            $t->Briefing = $this;
            $this->Events[] = $t;
            $offset += $t->getLength();
            $eventParsed += $t->getLength();
        }

        $this->Tags = [];
        $offset = 0x32a;
        for ($i = 0; $i < 32; $i++) {
            $t = (new Tag(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Tags[] = $t;
            $offset += $t->getLength();
        }

        $this->Strings = [];

        for ($i = 0; $i < 32; $i++) {
            $t = (new TIEString(substr($hex, $offset), $this->TIE))->loadHex();
            $this->Strings[] = $t;
            $offset += $t->getLength();
        }
        $this->BriefingLength = $offset;
    }

    public function getUsedTags()
    {
        $tags = [];
        /**
         * @var Event $event
         */
        foreach ($this->Events as $event) {
            if ($tag = $event->getTag()) {
                $tags[] = $tag;
            }
        }
        return array_unique($tags);
    }

    public function getUsedStrings()
    {
        $strings = [];
        /**
         * @var Event $event
         */
        foreach ($this->Events as $event) {
            if ($str = $event->getStr()) {
                $strings[] = $str;
            }
        }
        return array_unique($strings);
    }
}

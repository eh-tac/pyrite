<?php

namespace Pyrite\TIE;

use Pyrite\Summary;

class Message extends Base\MessageBase implements Summary
{
    public int $messageColour = 0;

    public Mission $mission;

    public function __construct(string $hex = null, ?\Pyrite\PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
        if ($TIE instanceof Mission) {
            $this->mission = $TIE;
        }
    }

    public function loadHex(): static
    {
        parent::loadHex();
        if (strlen($this->Message) && is_numeric($this->Message[0])) {
            $this->messageColour = (int) $this->Message[0];
        }
        return $this;
    }

    public function getMessageColourLabel(): string
    {
        return Constants::$MESSAGECOLOR[$this->messageColour];
    }

    public function __debugInfo(): array
    {
        $start = $this->messageColour !== 0 ? 1 : 0;
        return [
            'Message' => substr($this->Message, $start),
            'MessageColour' => $this->getMessageColourLabel(),
            'Triggers' => $this->Triggers,
            'EditorNote' => $this->EditorNote,
            'Trigger1OrTrigger2' => $this->Trigger1OrTrigger2
        ];
    }

    public function summaryHash(): array
    {
        $start = $this->messageColour !== 0 ? 1 : 0;
        $triggas = [(string)$this->Triggers[0]];
        $two = (string)$this->Triggers[1];
        if ($two !== 'Always') {
            $triggas[] = $this->Trigger1OrTrigger2 ? 'OR' : 'AND';
            $triggas[] = $two;
        }
        return [
            'Message' => substr($this->Message, $start),
            'MessageColour' => $this->getMessageColourLabel(),
            'Triggers' => implode("<br />", $triggas)
        ];
    }
}

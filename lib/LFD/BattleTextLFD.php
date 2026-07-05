<?php

namespace Pyrite\LFD;

class BattleTextLFD extends TextLFD
{
    public string $BattleName;
    public string $CutsceneName;
    public string $TitleBattle1;
    public string $TitleBattle2;
    public string $TitleCutscene1;
    public string $TitleCutscene2;
    public string $DeltName;
    public string $SystemName;
    public string $Frame;
    public array $MissionFilenames = [];
    public array $MissionDescriptions = [];

    public function __construct(string $hex = null, ?\Pyrite\PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
        if (count($this->Strings)) {
            list($this->BattleName, $this->CutsceneName) = $this->Strings[0];
            list($this->TitleBattle1, $this->TitleBattle2, $this->TitleCutscene1, $this->TitleCutscene2) = $this->Strings[1];
            list($this->DeltName, $this->SystemName, $this->Frame) = $this->Strings[2];
            $this->MissionFilenames    = $this->Strings[3]->SubStrings;
            $this->MissionDescriptions = array_slice($this->Strings, 4);
        } else {
            //        	print_r(['Error in Battle Text LFD', $this]);
        }
    }

    public function __debugInfo(): array
    {
        return [
            'type' => $this->HeaderType,
            'name' => $this->HeaderName,
            'length' => $this->HeaderLength,
            'battlename' => $this->BattleName,
            'cutscenename' => $this->CutsceneName,
            'titlebattle1' => $this->TitleBattle1,
            'titlebattle2' => $this->TitleBattle2,
            'titecust1' => $this->TitleCutscene1,
            'titlesc2' => $this->TitleCutscene2,
            'deltane' => $this->DeltName,
            'systema' => $this->SystemName,
            'frame' => $this->Frame,
            'missionfs' => $this->MissionFilenames,
            'missiodns' => $this->MissionDescriptions
        ];
    }
}

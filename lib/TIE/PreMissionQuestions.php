<?php

namespace Pyrite\TIE;

use Pyrite\PyriteModel;
use Pyrite\Summary;

class PreMissionQuestions extends Base\PreMissionQuestionsBase implements Summary
{
    protected function afterLoadHex(): void
    {
        if ($this->Length === 0) {
            $this->PreMissionQuestionsLength = 2;
        }
    }

    protected function QuestionLength(): int
    {
        if ($this->Length === 0) {
            return 0;
        }
        $text = substr($this->hex, 2, $this->Length);
        if (strpos($text, chr(10))) {
            list($question) = explode(chr(10), $text, 2);
            return strlen($question);
        }
        return 0;
    }

    protected function AnswerLength(): int
    {
        if ($this->Length === 0) {
            return 0;
        }
        $text = substr($this->hex, 2, $this->Length);
        if (strpos($text, chr(10))) {
            list(, $answer) = explode(chr(10), $text, 2);
            return strlen($answer);
        }
        return 0;
    }

    public function summaryHash(): array|false
    {
        if ($this->Length === 0) {
            return false;
        }
        return [
            'Question' => $this->Question,
            'Answer' => $this->Answer
        ];
    }
}

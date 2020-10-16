<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;

abstract class PreMissionQuestionsBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $PreMissionQuestionsLength;
    /** @var integer */
    public $Length;
    /** @var string */
    public $Question;
    /** @var integer */
    public const Spacer = 10;
    /** @var string */
    public $Answer;
    
    public function __construct($hex, $tie = null)
    {
        parent::__construct($hex, $tie);
        $this->beforeConstruct();
        $offset = 0;

        $this->Length = $this->getShort($hex, 0x0);
        $this->Question = $this->getChar($hex, 0x2, $this->QuestionLength());
        $offset = 0x2 + $this->QuestionLength();
        // static BYTE value Spacer = 10
        $offset += 1;
        $this->Answer = $this->getChar($hex, $offset, $this->AnswerLength());
        $offset += $this->AnswerLength();
        $this->PreMissionQuestionsLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "Question" => $this->Question,
            "Answer" => $this->Answer
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Length, 0x0);
        $this->writeChar($hex, $this->Question, 0x2);
        $this->writeByte($hex, 10, $offset);
        $this->writeChar($hex, $this->Answer, $offset);

        return $hex;
    }
    
    protected abstract function QuestionLength();
protected abstract function AnswerLength();
    public function getLength()
    {
        return $this->PreMissionQuestionsLength;
    }
}
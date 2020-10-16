<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class PostMissionQuestionsBase extends PyriteBase implements Byteable
{
    use HexDecoder;

    /** @var integer */
    public $PostMissionQuestionsLength;
    /** @var integer */
    public $Length;
    /** @var integer */
    public $QuestionCondition;
    /** @var integer */
    public $QuestionType;
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
        $this->QuestionCondition = $this->getByte($hex, 0x2);
        $this->QuestionType = $this->getByte($hex, 0x3);
        $this->Question = $this->getChar($hex, 0x4, $this->QuestionLength());
        $offset = 0x4 + $this->QuestionLength();
        // static BYTE value Spacer = 10
        $offset += 1;
        $this->Answer = $this->getChar($hex, $offset, $this->AnswerLength());
        $offset += $this->AnswerLength();
        $this->PostMissionQuestionsLength = $offset;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "QuestionCondition" => $this->getQuestionConditionLabel(),
            "QuestionType" => $this->getQuestionTypeLabel(),
            "Question" => $this->Question,
            "Answer" => $this->Answer
        ];
    }
    
    public function toHexString()
    {
        $hex = "";
        $offset = 0;

        $this->writeShort($hex, $this->Length, 0x0);
        $this->writeByte($hex, $this->QuestionCondition, 0x2);
        $this->writeByte($hex, $this->QuestionType, 0x3);
        $this->writeChar($hex, $this->Question, 0x4);
        $this->writeByte($hex, 10, $offset);
        $this->writeChar($hex, $this->Answer, $offset);

        return $hex;
    }
    
    public function getQuestionConditionLabel() {
        return isset($this->QuestionCondition) && isset(Constants::$QUESTIONCONDITION[$this->QuestionCondition]) ? Constants::$QUESTIONCONDITION[$this->QuestionCondition] : "Unknown";
    }

    public function getQuestionTypeLabel() {
        return isset($this->QuestionType) && isset(Constants::$QUESTIONTYPE[$this->QuestionType]) ? Constants::$QUESTIONTYPE[$this->QuestionType] : "Unknown";
    }
    protected abstract function QuestionLength();
protected abstract function AnswerLength();
    public function getLength()
    {
        return $this->PostMissionQuestionsLength;
    }
}
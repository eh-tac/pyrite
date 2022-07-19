<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\TIE\Constants;

abstract class PostMissionQuestionsBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PostMissionQuestionsLength INT */
    public $PostMissionQuestionsLength;
    /** @var integer 0x0 Length SHORT */
    public $Length;
    /** @var integer 0x2 QuestionCondition BYTE */
    public $QuestionCondition;
    /** @var integer 0x3 QuestionType BYTE */
    public $QuestionType;
    /** @var string 0x4 Question CHAR */
    public $Question;
    /** @var integer PV Spacer BYTE */
    public const Spacer = 10;
    /** @var string PV Answer CHAR */
    public $Answer;
    
    public function __construct($hex = null, $tie = null)
    {
        parent::__construct($hex, $tie);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex()
    {
        $hex = $this->hex;
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

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
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
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Length, $hex, 0x0);
        $hex = $this->writeByte($this->QuestionCondition, $hex, 0x2);
        $hex = $this->writeByte($this->QuestionType, $hex, 0x3);
        $hex = $this->writeChar($this->Question, $hex, 0x4);
        $hex = $this->writeByte(10, $hex, $offset);
        $hex = $this->writeChar($this->Answer, $hex, $offset);

        return $hex;
    }
    
    public function getQuestionConditionLabel() 
    {
        return isset($this->QuestionCondition) && isset(Constants::$QUESTIONCONDITION[$this->QuestionCondition]) ? Constants::$QUESTIONCONDITION[$this->QuestionCondition] : "Unknown";
    }

    public function getQuestionTypeLabel() 
    {
        return isset($this->QuestionType) && isset(Constants::$QUESTIONTYPE[$this->QuestionType]) ? Constants::$QUESTIONTYPE[$this->QuestionType] : "Unknown";
    }
    protected abstract function QuestionLength();
protected abstract function AnswerLength();
    public function getLength()
    {
        return $this->PostMissionQuestionsLength;
    }
}
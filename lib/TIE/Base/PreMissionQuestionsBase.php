<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;

abstract class PreMissionQuestionsBase extends PyriteBase implements Byteable
{
    use HexDecoder;
    use HexEncoder;

    /** @var integer  PreMissionQuestionsLength INT */
    public $PreMissionQuestionsLength;
    /** @var integer 0x0 Length SHORT */
    public $Length;
    /** @var string 0x2 Question CHAR */
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
        $this->Question = $this->getChar($hex, 0x2, $this->QuestionLength());
        $offset += $this->QuestionLength();
        // static BYTE value Spacer = 10
        $offset += 1;
        $this->Answer = $this->getChar($hex, $offset, $this->AnswerLength());
        $offset += $this->AnswerLength();
        $this->PreMissionQuestionsLength = $offset;
        return $this;
    }
    
    public function __debugInfo()
    {
        return [
            "Length" => $this->Length,
            "Question" => $this->Question,
            "Answer" => $this->Answer
        ];
    }
    
    public function toHexString($hex = null)
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        [$hex, $offset] = $this->writeShort($this->Length, $hex, 0x0);
        [$hex, $offset] = $this->writeChar($this->Question, $hex, 0x2);
        [$hex, $offset] = $this->writeByte(10, $hex, $offset);
        [$hex, $offset] = $this->writeChar($this->Answer, $hex, $offset);

        return $hex;
    }
    
    protected abstract function QuestionLength();
protected abstract function AnswerLength();
    public function getLength()
    {
        return $this->PreMissionQuestionsLength;
    }
}
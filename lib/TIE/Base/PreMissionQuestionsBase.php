<?php

namespace Pyrite\TIE\Base;

use Pyrite\Byteable;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;
use Pyrite\PyriteBase;
use Pyrite\PyriteModel;

abstract class PreMissionQuestionsBase extends PyriteBase implements Byteable, PyriteModel
{
    use HexDecoder;
    use HexEncoder;

    /** @var int PreMissionQuestionsLength INT */
	public int $PreMissionQuestionsLength;
    /** @var int 0x0 Length SHORT */
	public int $Length;
    /** @var string 0x2 Question CHAR */
	public string $Question;
    /** @var int PV Spacer BYTE */
	public const Spacer = 10;
    /** @var string PV Answer CHAR */
	public string $Answer;
    
    public function __construct(string $hex = null, ?PyriteModel $TIE = null)
    {
        parent::__construct($hex, $TIE);
    }

    /**
     * Process the $hex string provided in the constructor.
     * Separating the constructor and loading allows for the objects to be made from scratch.
     * @return $this 
     */
    public function loadHex(): static
    {
        $hex = $this->hex;
        $offset = 0;

        $this->Length = $this->getShort($hex, 0x0);
        $this->Question = $this->getChar($hex, 0x2, $this->QuestionLength());
        $offset = 0x2 + $this->QuestionLength();
        // static BYTE value Spacer = 10
        $offset += 1;
        $this->Answer = $this->getChar($hex, $offset, $this->AnswerLength());
        $offset += $this->AnswerLength();
        $this->PreMissionQuestionsLength = $offset;

        $this->hex = substr($this->hex, 0, $this->getLength());
        return $this;
    }
    
    public function __debugInfo(): array
    {
        return [
            "Length" => $this->Length,
            "Question" => $this->Question,
            "Answer" => $this->Answer
        ];
    }
    
    public function toHexString($hex = null): string
    {
        $hex = $hex ? $hex : str_pad("", $this->getLength(), chr(0));
        $offset = 0;

        $hex = $this->writeShort($this->Length, $hex, 0x0);
        $hex = $this->writeChar($this->Question, $hex, 0x2);
        $hex = $this->writeByte(10, $hex, $offset);
        $hex = $this->writeChar($this->Answer, $hex, $offset);

        return $hex;
    }
    
    protected abstract function QuestionLength();
protected abstract function AnswerLength();
    public function getLength(): int
    {
        return $this->PreMissionQuestionsLength;
    }
}
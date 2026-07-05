<?php

namespace Pyrite\LFD;

use Pyrite\Byteable;
use Pyrite\PyriteModel;
use Pyrite\HexDecoder;
use Pyrite\HexEncoder;

class DeltLFD extends LFD
{
    public static $MAX_WIDTH = 640;
    public static $MAX_HEIGHT = 480;

    // TODO requires close reading of
    // https://github.com/MikeG621/LfdReader/blob/master/Delt.cs
    public int $Left;
    public int $Top;
    public int $Right;
    public int $Bottom;
    public array $Rows = [];
    public int $Reserved = 0x00;

    public function __construct(public string $hex, public ?PyriteModel $TIE = NULL, int $length = 0)
    {
        parent::__construct($hex, $TIE);

        //		Hex::render($hex);
        $hex = substr($hex, 16); // header
        $this->Left = $this->getShort($hex, 0);
        $this->Top = $this->getShort($hex, 2);
        $this->Right = $this->getShort($hex, 4);
        $this->Bottom = $this->getShort($hex, 6);
        $rest = substr($hex, 8, $length);

        while ($rest) {
            $row = new Row($rest);
            $rest = substr($rest, $row->getLength());
            $this->Rows[] = $row;
        }
    }

    public function width(): int
    {
        return $this->Right - $this->Left + 1;
    }

    public function height(): int
    {
        return $this->Bottom - $this->Top + 1;
    }

    public function __debugInfo(): array
    {
        return [
            'type' => $this->HeaderType,
            'name' => $this->HeaderName,
            'length' => $this->HeaderLength,
            'left' => $this->Left,
            'top' => $this->Top,
            'right' => $this->Right,
            'bottom' => $this->Bottom,
            'width' => $this->width(),
            'height' => $this->height()
            //            'rows' => $this->Rows,
        ];
    }

    public function draw()
    {
        $image = imagecreate($this->width(), $this->height());
        $palette = json_decode(file_get_contents('../LFD/palette.json'), true);
        foreach ($palette as $color) {
            imagecolorallocate($image, $color['rgb']['r'], $color['rgb']['g'], $color['rgb']['b']);
        }
        /** @var Row $row */
        foreach ($this->Rows as $row) {
            $row->paint($image);
        }
        return $image;
    }
}

// rows are read from the top down, left to right
// class Row implements Byteable
// {
//     use HexDecoder;
//     use HexEncoder;
//     public int $Length; // number of pixels defined in that row. # pixels = Length >> 1.
//     public int $Left; // used for 'broken' images where there are blank spots e.g. map has gap for officer's head. For images without blanks, this is usally = delt.left
//     public int $Top; // because of broken images, two rows can have the same top value
//     public string $ColorIndexes; // if (Length % 2 == 0) - uncompressed indexed values for the colour palette
//     public OpCode $Operations; // else - operations array. continues until # pixels = length

//     private bool $IsCompressed;
//     private int $NumPixels;

//     public function __construct(string $hex, public ?PyriteModel $TIE = NULL)
//     {
//         $this->Length = $this->getShort($hex);
//         $this->IsCompressed = $this->Length % 2 === 1;
//         $this->NumPixels = $this->Length >> 1;

//         if ($this->Length) {
//             $this->Left = $this->getShort($hex, 2);
//             $this->Top = $this->getShort($hex, 4);
//             if ($this->IsCompressed) {
//                 // op code shit
//                 $this->Operations = new OpCode($hex);
//             } else {
//                 $this->ColorIndexes = substr($hex, 6, $this->NumPixels);
//             }
//         }
//     }

//     public function getLength()
//     {
//         if ($this->Length === 0) {
//             return 2;
//         } elseif ($this->IsCompressed) {
//             return $this->Length + 6;
//         } else {
//             return $this->NumPixels + 6;
//         }
//     }

//     public function paint(\GdImage $image, $palette = null)
//     {
//         $y = $this->Top;
//         for ($i = 0; $i < $this->NumPixels; $i++) {
//             $x = $this->Left + $i;
//             $color = $this->ColorIndexes[$i];
//             imagesetpixel($image, $x, $y, $this->getByte($color));
//         }
//     }
// }

// class OpCode
// {
//     public $Value; // odd is repeat, even is read
//     public $ColorIndexes; // if (Value & 1 == 0) - byte[value / 2]
//     public $ColorIndex; // else (single byte)

//     private $IsRepeat;

//     public function __construct(public string $hex)
//     {
//         $this->IsRepeat = TRUE; // ??
//     }

//     public function getLength()
//     {
//         return $this->IsRepeat ? 2 : ($this->Value / 2 + 1);
//     }
// }

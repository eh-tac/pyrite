<?php

namespace Pyrite\LFD;

use Pyrite\PyriteModel;

class Row extends Base\RowBase
{

  // public int $Length; // number of pixels defined in that row. # pixels = Length >> 1.
  // public int $Left; // used for 'broken' images where there are blank spots e.g. map has gap for officer's head. For images without blanks, this is usally = delt.left
  // public int $Top; // because of broken images, two rows can have the same top value
  // public string $ColorIndexes; // if (Length % 2 == 0) - uncompressed indexed values for the colour palette
  // public OpCode $Operations; // else - operations array. continues until # pixels = length

  private bool $IsCompressed;
  private int $NumPixels;

  public function __construct(string $hex = null, public ?PyriteModel $TIE = NULL)
  {
    parent::__construct($hex, $TIE);
    $this->Length = $this->getShort($hex);
    $this->IsCompressed = $this->Length % 2 === 1;
    $this->NumPixels = $this->Length >> 1;

    if ($this->Length) {
      $this->Left = $this->getShort($hex, 2);
      $this->Top = $this->getShort($hex, 4);
      if ($this->IsCompressed) {
        // op code shit
        // $this->Operations = new OpCode($hex);
      } else {
        // $this->ColorIndexes = substr($hex, 6, $this->NumPixels);
      }
    }
  }

  public function getLength(): int
  {
    if ($this->Length === 0) {
      return 2;
    } elseif ($this->IsCompressed) {
      return $this->Length + 6;
    } else {
      return $this->NumPixels + 6;
    }
  }

  public static function fromHex(string $hex, ?PyriteModel $TIE = null): Row
  {
    return (new Row($hex, $TIE))->loadHex();
  }

  public function __toString(): string
  {
    return '';
  }

  protected function ColorCount(): int
  {
    return 0;
  }
  protected function OpCount(): int
  {
    return 0;
  }

  public function paint(\GdImage $image, $palette = null)
  {
    $y = $this->Top;
    for ($i = 0; $i < $this->NumPixels; $i++) {
      $x = $this->Left + $i;
      $color = $this->ColorIndexes[$i];
      imagesetpixel($image, $x, $y, $color);
    }
  }
}

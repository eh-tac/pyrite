<?php

namespace Pyrite\XWA;

class Event extends Base\EventBase
{
  protected function VariableCount()
  {
    switch ($this->Type) {
      case Constants::$EVENTTYPE_SEEK:
      case Constants::$EVENTTYPE_PAGEBREAK:
      case Constants::$EVENTTYPE_CLEARFGTAGS:
      case Constants::$EVENTTYPE_CLEARTEXTTAGS:
      case Constants::$EVENTTYPE_ENDBRIEFING:
        return 0;
      case Constants::$EVENTTYPE_SHIPINDEX:
      case Constants::$EVENTTYPE_TITLETEXT:
      case Constants::$EVENTTYPE_CAPTIONTEXT:
      case Constants::$EVENTTYPE_FGTAG1:
      case Constants::$EVENTTYPE_FGTAG2:
      case Constants::$EVENTTYPE_FGTAG3:
      case Constants::$EVENTTYPE_FGTAG4:
      case Constants::$EVENTTYPE_FGTAG5:
      case Constants::$EVENTTYPE_FGTAG6:
      case Constants::$EVENTTYPE_FGTAG7:
      case Constants::$EVENTTYPE_FGTAG8:
      case Constants::$EVENTTYPE_CHANGEREGION:
      case Constants::$EVENTTYPE_ZOOMPARAGRAPH:
        return 1;
      case Constants::$EVENTTYPE_MOVEMAP:
      case Constants::$EVENTTYPE_ZOOMMAP:
      case Constants::$EVENTTYPE_SHIPCRAFTDATA:
      case Constants::$EVENTTYPE_ROTATEICON:
        return 2;
      case Constants::$EVENTTYPE_SETICON:
      case Constants::$EVENTTYPE_MOVEICON:
        return 3;
      case Constants::$EVENTTYPE_TEXTTAG1:
      case Constants::$EVENTTYPE_TEXTTAG2:
      case Constants::$EVENTTYPE_TEXTTAG3:
      case Constants::$EVENTTYPE_TEXTTAG4:
      case Constants::$EVENTTYPE_TEXTTAG5:
      case Constants::$EVENTTYPE_TEXTTAG6:
      case Constants::$EVENTTYPE_TEXTTAG7:
      case Constants::$EVENTTYPE_TEXTTAG8:
        return 4;
      default:
        throw new \Exception("Unknown event type " . $this->Type);
    }
  }

  public static function fromHex(string $hex, $TIE = null)
  {
    return (new Event($hex, $TIE))->loadHex();
  }

  public function __toString()
  {
    return '';
  }
}

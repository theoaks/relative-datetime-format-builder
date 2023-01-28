<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

enum Unit: string
{
    case Sec = "sec";
    case Second = "second";
    case Min = "min";
    case Minute = "minute";
    case Hour = "hour";
    case Day = "day";
    case Fortnight = "fortnight";
    case Forthnight = "forthnight";
    case Month = "month";
    case Year = "year";
    case Weeks = "weeks";
}

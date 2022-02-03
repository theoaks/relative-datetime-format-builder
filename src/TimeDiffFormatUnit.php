<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

abstract class TimeDiffFormatUnit extends DateFormatUnit
{
    public function __construct(
        Unit $unit,
        int $diff
    ) {
        if (!in_array($unit, [
            Unit::Hour,
            Unit::Min,
            Unit::Minute,
            Unit::Sec,
            Unit::Second,
        ])) {
            throw new \InvalidArgumentException("Please provide a time unit");
        }

        parent::__construct($unit, Ordinal::This, $diff);
    }

    public function __toString(): string
    {
        return parent::__toString();
    }
}

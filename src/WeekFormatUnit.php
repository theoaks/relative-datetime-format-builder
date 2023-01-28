<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

class WeekFormatUnit extends DateFormatUnit
{
    public function __construct(Ordinal $ordinal = Ordinal::This, ?int $diff = null)
    {
        parent::__construct(
            Unit::Weeks,
            $ordinal,
            $diff
        );
    }
}
<?php

use Oaks\RelativeDatetimeFormatBuilder\RelativeDateTimeFormatBuilder;

function oaks_in_between(float $num, float $lower, float $upper, bool $include_limits = false): bool
{
    if ($include_limits) {
        return $num >= $lower && $num <= $upper;
    } else {
        return $num > $lower && $num < $upper;
    }
}

function oaks_format_builder(): RelativeDateTimeFormatBuilder
{
    return new Oaks\RelativeDatetimeFormatBuilder\RelativeDateTimeFormatBuilder();
}